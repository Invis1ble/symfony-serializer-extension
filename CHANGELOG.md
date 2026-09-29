# Changelog

## [1.2.0] - 2026-09-29

### Added

- Support Symfony Serializer 8 on PHP 8.4.1 or later while retaining support for
  Symfony 6.4 on PHP 8.1 and Symfony 7 on PHP 8.2.
- Integration coverage for URI round trips, JSON, format and context handling,
  cached support checks, and invalid input across the supported Symfony versions.

### Changed

- Use stable development dependencies and Guzzle PSR-7 fixtures directly.
- Default the development container to PHP 8.4 and test PHP 8.1, 8.2, 8.4, and 8.5
  in CI, including both PSR-7 major versions.

### Fixed

- Restore CI compatibility with current Buildx and supported GitHub Actions
  runtimes, retaining all quality, test, coverage, and Dockerfile checks.
- Refresh Debian package pins, update Rector configuration, and share its cache
  with the host without including generated files in coding standard checks.

The normalizer API and runtime behavior are unchanged. Existing `^1.0` and `^1.1`
Composer constraints allow this release; projects explicitly requiring an older
version can update their constraint to `^1.2`.

[1.2.0]: https://github.com/Invis1ble/symfony-serializer-extension/compare/v1.1.2...v1.2.0
