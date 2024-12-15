{ pkgs, ... }: {
  # Which nixpkgs channel to use.
  channel = "stable-24.05"; # or "unstable"

  # Use https://search.nixos.org/packages to find packages
  packages = [
    pkgs.php
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.phpPackages.composer
    pkgs.phpPackages.phpunit
    pkgs.nodejs_20
    pkgs.nodePackages.nodemon
    pkgs.nixos-rebuild
    pkgs.git
    pkgs.curl
  ];

  # Sets environment variables in the workspace
  env = {
    # Set PHP-related environment variables
    PHP_PATH = pkgs.php.bin;
  };

  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    extensions = [
      "esbenp.prettier-vscode"   # For code formatting (optional)
      "ms-azuretools.vscode-docker" # For Docker integration (optional)
      "xdebug-vscode.xdebug" # For debugging (optional)
    ];

    # Enable previews
    previews = {
      enable = true;
      previews = {
        # web = {
        #   Example: run Laravel's Artisan server or any background command for the preview.
        #   command = ["php" "artisan" "serve"];
        #   manager = "web";
        #   env = {
        #     PORT = "$PORT";
        #   };
        # };
      };
    };

    # Workspace lifecycle hooks
    workspace = {
      # Runs when a workspace is first created
      onCreate = {
        # Example: Install Composer dependencies for Laravel
        # Run composer install to set up your Laravel project
        # composer-install = "composer install";
      };
      # Runs when the workspace is (re)started
      onStart = {
        # Example: start a background task to watch and re-build backend code
        # watch-backend = "npm run watch-backend";
        # or you can start the Laravel development server with:
        # start-laravel-server = "php artisan serve --host 0.0.0.0 --port 8080";
      };
    };
  };
}
