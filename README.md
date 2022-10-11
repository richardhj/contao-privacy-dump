<div align="center">
  <p><img src="/docs/logo.svg" width="200" alt=""></p>
  <p>A Contao plugin to create a purged and anonymized database dump</p>
</div>

## About

This Symfony bundle provides utilities for creating anonymized database dumps.

It is the equivalent of `mysqldump`, with additional features, at the cost of performance (PHP implementation).
The main purpose of this tool is to create anonymized dumps, in order to comply with GDPR regulations.

## Features

- Data converters (transform the data before it is dumped to the file)
- Table filtering
- Tables include list (only these tables will be included in the dump)
- Tables exclude list (not included in the dump)

## Installation

```shell script
composer require richardhj/contao-privacy-dump
```

## Usage

```shell script
php vendor/bin/contao-console privacy-dump contao contao --filename dump.sql
```

![](/docs/screenshot_tl_member.png)

## Importing the anonymized dump

In combination with `richardhj/contao-backup-manager`:

1. Create anonymized dump on the remote system.
2. Download the anonymized dump (with `scp`) and place the file in `/backups`.
3. Import the purged database dump on your local machine.

```shell script
php vendor/bin/contao-console backup-manager:restore contao local dump.sql
```

This workflow can be represented in a Deployer recipe, see
[these recipes](https://github.com/terminal42/deployer-recipes/blob/master/recipe/database-helpers.php).

Make sure to call the restore command in the correct instance!

## Configuration

The plugin is pre-configured to purge personal data in tl_member, tl_opt_in and the like.

You can override and extend the configuration:

```yml
richardhj_privacy_dump:
  options:
    contao:
      tables:
        tl_my_custom_table:
          truncate: true

        tl_iso_address:
          converters:
            firstname:
              converter: 'anonymizeText'
            lastname:
              converter: 'anonymizeText'
            street:
              converter: 'anonymizeText'
            company:
              converter: 'anonymizeText'
            email:
              converter: 'randomizeEmail'
              cache_key: 'member_email'
              unique: true
            username:
              converter: 'randomizeEmail'
              cache_key: 'member_email'
              unique: true
```
