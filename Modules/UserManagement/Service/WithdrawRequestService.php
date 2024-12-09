<?php

namespace Modules\UserManagement\Service;


use App\Service\BaseService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\TransactionManagement\Traits\TransactionTrait;
use Modules\UserManagement\Entities\WithdrawRequest;
use Modules\UserManagement\Repository\WithdrawMethodRepositoryInterface;
use Modules\UserManagement\Repository\WithdrawRequestRepositoryInterface;
use Modules\UserManagement\Service\Interface\WithdrawRequestServiceInterface;

class WithdrawRequestService extends BaseService implements WithdrawRequestServiceInterface
{
    use TransactionTrait;

    protected $withdrawRequestRepository;

    public function __construct(WithdrawRequestRepositoryInterface $withdrawRequestRepository)
    {
        parent::__construct($withdrawRequestRepository);
        $this->withdrawRequestRepository = $withdrawRequestRepository;
    }

    public function update(int|string $id, array $data = []): ?Model
    {
        $withdrawRequest = $this->withdrawRequestRepository->findOne(id: $id, relations: ['user' => []]);
        if (array_key_exists('rejection_cause', $data) && !is_null($data['rejection_cause'])) {
            $attributes['rejection_cause'] = $data['rejection_cause'];
        }
        if (array_key_exists('approval_note', $data) && !is_null($data['approval_note'])) {
            $attributes['approval_note'] = $data['approval_note'];
        }
        if (array_key_exists('denied_note', $data) && !is_null($data['denied_note'])) {
            $attributes['denied_note'] = $data['denied_note'];
        }
        if ($data['status'] == DENIED) {
            $this->withdrawRequestCancelTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
        }
        if ($data['status'] == SETTLED) {
            $this->withdrawRequestAcceptTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
        }
        if ($data['status'] == 'reverse') {
            $this->withdrawRequestReverseTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
        }
        if ($data['status'] == 'reverse') {
            $attributes['status'] = PENDING;
            $this->withdrawRequestRepository->update(id: $id, data: $attributes);
        }
        if ($withdrawRequest->status == PENDING && $data['status'] == APPROVED) {
            $attributes['status'] = APPROVED;
            $this->withdrawRequestRepository->update(id: $id, data: $attributes);
        }
        if ($withdrawRequest->status == PENDING && $data['status'] == DENIED) {
            $attributes['status'] = DENIED;
            $this->withdrawRequestRepository->update(id: $id, data: $attributes);
        }
        if ($withdrawRequest->status == APPROVED && $data['status'] == SETTLED) {
            $attributes['status'] = SETTLED;
            $this->withdrawRequestRepository->update(id: $id, data: $attributes);
        }
        $withdrawRequestData = $this->withdrawRequestRepository->findOne(id: $id, relations: ['user' => []]);
        $this->withdrawRequestNotificationSendDriver(data: $data, withdrawRequestData: $withdrawRequestData);
        return $withdrawRequestData;
    }

    public function multipleUpdate(array $data = []): void
    {
        if (array_key_exists('status', $data) && !is_null($data['status']) && array_key_exists('ids', $data) && (count($data['ids']) > 0)) {
            foreach ($data['ids'] as $id) {
                $withdrawRequest = $this->withdrawRequestRepository->findOne(id: $id, relations: ['user' => []]);
                if ($data['status'] == 'reverse') {
                    $attributes['status'] = PENDING;
                } else {
                    $attributes['status'] = $data['status'];
                }

                if (array_key_exists('rejection_cause', $data) && !is_null($data['rejection_cause'])) {
                    $attributes['rejection_cause'] = $data['rejection_cause'];
                }
                if (array_key_exists('approval_note', $data) && !is_null($data['approval_note'])) {
                    $attributes['approval_note'] = $data['approval_note'];
                }
                if (array_key_exists('denied_note', $data) && !is_null($data['denied_note'])) {
                    $attributes['denied_note'] = $data['denied_note'];
                }
                DB::beginTransaction();
                if ($data['status'] == DENIED) {
                    $this->withdrawRequestCancelTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
                }
                if ($data['status'] == SETTLED) {
                    $this->withdrawRequestAcceptTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
                }
                if ($data['status'] == 'reverse') {
                    $this->withdrawRequestReverseTransaction($withdrawRequest->user, $withdrawRequest->amount, $withdrawRequest);
                }
                $this->withdrawRequestRepository->update(id: $id, data: $attributes);
                DB::commit();
                $withdrawRequestData = $this->withdrawRequestRepository->findOne(id: $id, relations: ['user' => []]);
                $this->withdrawRequestNotificationSendDriver(data: $data, withdrawRequestData: $withdrawRequestData);
            }
        }
    }

    private function withdrawRequestNotificationSendDriver($data, $withdrawRequestData)
    {
        if ($data['status'] == DENIED) {
            $push = getNotification('withdraw_request_rejected');
            sendDeviceNotification(fcm_token: $withdrawRequestData->user->fcm_token,
                title: translate($push['title']),
                description: translate(textVariableDataFormat(value: $push['description'], withdrawNote: $withdrawRequestData?->denied_note)),
                status: $push['status'],
                action: 'withdraw_rejected',
                user_id: $withdrawRequestData?->user->id
            );
        } elseif ($data['status'] == SETTLED) {
            $push = getNotification('withdraw_request_settled');
            sendDeviceNotification(fcm_token: $withdrawRequestData->user->fcm_token,
                title: translate($push['title']),
                description: translate(textVariableDataFormat(value: $push['description'])),
                status: $push['status'],
                action: 'withdraw_settled',
                user_id: $withdrawRequestData?->user->id
            );
        } elseif ($data['status'] == APPROVED) {
            $push = getNotification('withdraw_request_approved');
            sendDeviceNotification(fcm_token: $withdrawRequestData->user->fcm_token,
                title: translate($push['title']),
                description: translate(textVariableDataFormat(value: $push['description'])),
                status: $push['status'],
                action: 'withdraw_approved',
                user_id: $withdrawRequestData?->user->id
            );
        } else {
            $push = getNotification('withdraw_request_reversed');
            sendDeviceNotification(fcm_token: $withdrawRequestData?->user->fcm_token,
                title: translate($push['title']),
                description: translate(textVariableDataFormat(value: $push['description'])),
                status: $push['status'],
                action: 'withdraw_reversed',
                user_id: $withdrawRequestData?->user->id
            );
        }
    }

}
