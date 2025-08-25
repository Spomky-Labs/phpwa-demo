# Symfony + PWA = 💕

## Introduction

This application is a PWA (Progressive Web Application) built with Symfony and [PHPWA](https://github.com/Spomky-Labs/phpwa-bundle).

A live demo is available here: https://pwa.spomky-labs.net/

## Getting Started

This project uses [Castor](https://github.com/jolicode/castor) to simplify development tasks. All commands below assume you have `castor` installed globally (via Composer or PHAR).

### Prerequisites

- Docker
- Docker Compose v2.10+
- [Castor](https://github.com/jolicode/castor#installation)

### Launch the Project

```bash
castor build     # Build the Docker images
castor start     # Start the application and its services
```

Then open [https://localhost](https://localhost) in your browser and accept the self-signed TLS certificate if prompted.

To stop the project:

```bash
castor stop
```

To rebuild everything from scratch:

```bash
castor destroy --force
castor build
castor start
```

## Useful Commands

| Command                  | Description                                      |
|--------------------------|--------------------------------------------------|
| `castor frontend`        | Compile frontend assets (Importmap, Tailwind…)   |
| `castor update`          | Update PHP deps, run migrations, etc.            |
| `castor phpunit`         | Run PHPUnit tests with coverage                  |
| `castor ecs`             | Run Easy Coding Standard checks                  |
| `castor ecs-fix`         | Fix code style issues                            |
| `castor rector`          | Run Rector in dry-run mode                       |
| `castor rector-fix`      | Apply Rector changes                             |
| `castor phpstan`         | Run static analysis with PHPStan                 |
| `castor infect`          | Run mutation testing with Infection              |
| `castor deptrac`         | Check architectural boundaries                   |
| `castor lint`            | Run syntax checks                                |
| `castor check-licenses`  | Check that all dependencies use allowed licenses |

## License

This project is licensed under the MIT License.
