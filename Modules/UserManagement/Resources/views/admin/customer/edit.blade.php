@extends('adminmodule::layouts.master')

@section('title', translate('Update_Customer'))

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center mb-4">
                <h2 class="fs-22 text-capitalize">{{ translate('update_customer') }}</h2>
            </div>

            <form action="{{ route('admin.customer.update', ['id' => $customer->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <h5 class="text-primary text-uppercase mb-4">{{ translate('general_info') }}</h5>

                                <div class="row align-items-end">
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="f_name"
                                                   class="mb-2 text-capitalize">{{ translate('first_name') }}</label>
                                            <input type="text" value="{{ $customer?->first_name }}" name="first_name"
                                                   id="f_name" class="form-control"
                                                   placeholder="{{ translate('Ex: Maximilian') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="l_name" class="mb-2">{{ translate('last_name') }}</label>
                                            <input type="text" value="{{ $customer?->last_name }}" name="last_name"
                                                   id="l_name" class="form-control"
                                                   placeholder="{{ translate('Ex: Schwarzmüller') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="p_email" class="mb-2">{{ translate('email') }}</label>
                                            <input type="email" value="{{ $customer->email }}" name="email"
                                                   id="p_email" class="form-control"
                                                   placeholder="{{ translate('Ex: company@company.com') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="identity_type"
                                                   class="mb-2">{{ translate('identity_type') }}</label>
                                            <select name="identification_type" class="js-select text-capitalize"
                                                    id="identity_type">
                                                <option value="passport"
                                                    {{ $customer->identification_type == 'passport' ? 'selected' : '' }}>
                                                    {{ translate('passport') }}</option>
                                                <option value="nid"
                                                    {{ $customer->identification_type == 'nid' ? 'selected' : '' }}>
                                                    {{ translate('NID') }}</option>
                                                <option value="driving_license"
                                                    {{ $customer->identification_type == 'driving_license' ? 'selected' : '' }}>
                                                    {{ translate('driving_license') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label for="identity_card_num"
                                                   class="mb-2">{{ translate('identity_number') }}</label>
                                            <input type="text" value="{{ $customer->identification_number }}"
                                                   name="identification_number" id="identity_card_num"
                                                   class="form-control"
                                                   placeholder="{{ translate('Ex: 3032') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex flex-column justify-content-around gap-3">
                                    <h5 class="text-center text-capitalize">{{ translate('customer_image') }}</h5>

                                    <div class="d-flex justify-content-center">
                                        <div class="upload-file auto">
                                            <input type="file" name="profile_image" class="upload-file__input"
                                                   accept=".jpg, .jpeg, .png">
                                            <span class="edit-btn show">
                                                <img
                                                    src="{{ asset('public/assets/admin-module/img/svg/edit-circle.svg') }}"
                                                    alt="" class="svg">
                                            </span>
                                            <div
                                                class="upload-file__img border-gray d-flex justify-content-center align-items-center w-180 h-180 p-0">
                                                <img class="upload-file__img__img h-100" width="180" height="180"
                                                     loading="lazy"
                                                     src="{{ onErrorImage(
                                                        $customer?->profile_image,
                                                        asset('storage/app/public/customer/profile') . '/' . $customer?->profile_image,
                                                        asset('public/assets/admin-module/img/avatar/avatar.png'),
                                                        'customer/profile/',
                                                    ) }}"
                                                     alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="opacity-75 mx-auto max-w220">
                                        {{ translate('JPG, JPEG, PNG Less Than 1MB') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column justify-content-around gap-3">
                                    <h5 class="text-capitalize">{{ translate('identity_card_image') }}</h5>
                                    <div class="d-flex gap-3 flex-wrap">
                                        @foreach ($customer->identification_image as $index => $img)
                                            <div class="remove-upload-file upload-file__img_banner mb-20 position-relative">
                                                <!-- Close button -->
                                                <button class="spartan_remove_row border-0 remove-old-image"
                                                        type="button">
                                                    <i class="tio-clear"></i>
                                                </button>
                                                <!-- Existing image -->
                                                <img
                                                    src="{{ asset('storage/app/public/customer/identity') }}/{{ $img }}"
                                                    class="existing_image"
                                                    style="width: 100%; height: 130px;">
                                                <input type="hidden" name="existing_identity_images[]"
                                                       value="{{ $img }}">
                                            </div>
                                        @endforeach
                                        {{--                                        @if(count($employee->identification_image)<3)--}}
                                        <div class="upload-file d-flex custom" id="multi_image_picker">

                                        </div>
                                        {{--                                        @endif--}}
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card overflow-visible mt-3">
                    <div class="card-body">
                        <h5 class="text-primary text-uppercase mb-4">{{ translate('account_information') }}</h5>

                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="phone_number" class="mb-2">{{ translate('phone') }}</label>
                                    <input type="tel" pattern="[0-9]{1,14}" value="{{ $customer->phone }}"
                                           name="phone" id="phone_number" class="form-control w-100 text-dir-start"
                                           placeholder="{{ translate('Ex: xxxxx xxxxxx') }}" required>
                                    <input type="hidden" id="phone_number-hidden-element" name="phone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 input-group_tooltip">
                                    <label for="password" class="mb-2">{{ translate('password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="{{ translate('Ex: ********') }}">
                                    <i id="password-eye" class="mt-3 bi bi-eye-slash-fill text-primary tooltip-icon"
                                       data-bs-toggle="tooltip" data-bs-title=""></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 input-group_tooltip">
                                    <label for="confirm_password"
                                           class="mb-2">{{ translate('confirm_password') }}</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                           class="form-control" placeholder="{{ translate('Ex: ********') }}">
                                    <i id="conf-password-eye"
                                       class="mt-3 bi bi-eye-slash-fill text-primary tooltip-icon"
                                       data-bs-toggle="tooltip" data-bs-title=""></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="text-primary text-uppercase mb-4">{{ translate('upload_other_documents') }}</h5>
                        <div class="d-flex flex-wrap gap-3">
                            @if ($customer->other_documents != null)
                                @foreach ($customer->other_documents as $document)
                                    <div class='show-image'>
                                        <div class="file__value" data-document="{{ $document }}">
                                            <div class="file__value--text">{{ $document }}</div>
                                            <div class="file__value--remove" data-id="{{ $document }}">
                                            </div>
                                            <input type="hidden" name="existing_documents[]"
                                                   value="{{ $document }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex flex-wrap gap-3" id="selected-files-container"></div>
                            <div id="input-data"></div>
                            <!-- Upload New Documents -->
                            <div class="upload-file file__input" id="file__input">
                                <input type="file" class="upload-file__input2" multiple="multiple"
                                >
                                <div class="upload-file__img2">
                                    <div class="upload-box rounded media gap-4 align-items-center p-4 px-lg-5">
                                        <i class="bi bi-cloud-arrow-up-fill fs-20"></i>
                                        <div class="media-body">
                                            <p class="text-muted mb-2 fs-12">{{ translate('upload') }}</p>
                                            <h6 class="fs-12 text-capitalize">{{ translate('file_or_image') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-3">
                    <button class="btn btn-primary" type="submit">{{ translate('save') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- End Main Content -->

@endsection

@push('script')
    <link href="{{ asset('public/assets/admin-module/css/intlTelInput.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('public/assets/admin-module/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/assets/admin-module/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ asset('public/assets/admin-module/js/password.js') }}"></script>

    <script>
        "use strict";
        initializePhoneInput("#phone_number", "#phone_number-hidden-element");
        document.querySelectorAll('.upload-file__input').forEach(function (input) {
            input.addEventListener('change', function (event) {
                var file = event.target.files[0];
                var card = event.target.closest('.upload-file');
                var textbox = card.querySelector('.upload-file__textbox');
                var imgElement = card.querySelector('.upload-file__img__img');

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        textbox.style.display = 'none';
                        imgElement.src = e.target.result;
                        imgElement.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
        getCount();
        $(".remove-old-image").on('click', function () {
            $(this).closest('.remove-upload-file').remove();
            getCount();
        })

        function getCount() {
            let inputFields = document.querySelectorAll('input[name="existing_identity_images[]"]');
            let data = Array.from(inputFields).filter(input => input.value.trim() !== '').length;

            let inputFields1 = document.querySelectorAll('input[name="identity_images[]"]');
            let data1 = Array.from(inputFields1).filter(input => input.value.trim() !== '').length;
            const maxCount = parseInt(data + data1);
            if (maxCount < 5) {
                $("#multi_image_picker .upload-file__img:last-child").removeClass('d-none');
            } else {

                $("#multi_image_picker .upload-file__img:last-child").addClass('d-none');
            }
            return parseInt(5 - data);
        }


        $("#multi_image_picker").spartanMultiImagePicker({
            fieldName: 'identity_images[]',
            maxCount: getCount(),
            rowHeight: '130px',
            groupClassName: 'upload-file__img upload-file__img_banner',
            placeholderImage: {
                image: "{{ asset('public/assets/admin-module/img/document-upload.png') }}",
                width: '34px',
            },
            dropFileLabel: `
                <h6 id="dropAreaLabel" class="mt-2 fw-semibold">
                    <span class="text-info">{{ translate('Click to upload') }}</span>
                    <br>
                    {{ translate('or drag and drop') }}
            </h6>`,
            onAddRow: function (index) {
                getCount();
            },

            onRenderedPreview: function (index) {
                if ($(".file_upload").find(".img_").length > 0) {
                    $("#dropAreaLabel").hide();
                }
                $(".file_upload").on("dragenter", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).find('#dropAreaLabel').hide();
                    $(this).find('.spartan_image_placeholder').hide();
                });
                toastr.success('{{ translate('image_added') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onRemoveRow: function (index) {
                getCount();
            },
            onExtensionErr: function (index, file) {
                toastr.error('{{ translate('please_only_input_png_or_jpg_type_file') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onSizeErr: function (index, file) {
                toastr.error('{{ translate('file_size_too_big') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });

        $(".file_upload").on("dragenter", function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).find('#dropAreaLabel').hide();
            $(this).find('.spartan_image_placeholder').hide();
        });

        $(".file_upload").on("dragover", function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    </script>
@endpush