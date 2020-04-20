# Change Log

## 0.6.4 (2020-04-20)

- Fix a bug where heraldry that existed but wasn't in the cache would cause an error

## 0.6.3 (2020-04-19)

- Add cyberpunk chop shop generator to the quick generators page
- Update a ton of dependencies

## 0.6.2 (2020-04-09)

- Add Plausible tracking snippet

## 0.6.1 (2020-03-18)

- Change templates to support v0.11.0 of World API

## 0.6.0 (2020-01-19)

- Save rendered HTML of generated regions and cultures
- Change displays to use saved rendered HTML
- Fix language description display
- Fix description of religion in culture display
- Remove PDF save for cultures (for now)
- Remove deprecated Docker development workflow

## 0.5.2 (2020-01-15)

- Fix display of cultures

## 0.5.1 (2020-01-14)

- Update HeraldryGenerator to pull from world API 0.9.0 or later

## 0.5.0 (2020-01-12)

- Add user accounts
- Add ability to save results to the database for cultures, regions, and heraldry
- Add blog articles to front page
- Add personal dashboard
- Change style of navigation bar to emphasize active page
- Center content on heraldry display page
- Add "most recent" to culture, region, and heraldry pages
- Add field shape selection to heraldry generator

## 0.4.2 (2019-12-02)

- Add Fathom site ID

## 0.4.1 (2019-12-02)

- Make Fathom domain configurable

## 0.4.0 (2019-09-13)

Upgrade to Laravel 6

### Change List

- Upgrade to Laravel 6
- Switch to using phpredis instead of predis
- Fix remaining bugs in heraldry references

## 0.3.1 (2019-09-13)

### Change List

- Fix a bug in the heraldry router

## 0.3.0 (2019-09-13)

### Change List

- Make use of the new heraldry API
- Update dependencies
- Update to PHP 7.3
- Update to Node.js 12.10

## 0.2.8 (2019-09-03)

### Change List

- Make Redis port and password ENV configurable

## 0.2.7 (2019-07-21)

### Change List

- Fix food and drink display

## 0.2.6 (2019-07-21)

### Change List

- Updated composer dependencies
- Updated npm dependencies

## 0.2.5 (2019-07-01)

### Change List

- Support the new naming language feature of 0.2.2 of the API

## 0.2.4 (2019-06-30)

### Change List

- Update to use the new 0.2.3 version of the World API
- Fix some small display bugs

## 0.2.3 (2019-06-29)

### Change List

- Fix typo in CSS that prevented body font from loading

## 0.2.2 (2019-06-28)

For archival purposes, I added PDF generation for cultures so you can locally save your results.

### Change List

- Add PDF generation for cultures

## 0.2.1 (2019-06-26)

This is a typography release.

### Change List

- Add website icons
- Increase font size across the board
- Replace typefaces with new ones

## 0.2.0 (2019-06-26)

This version moves to using manual semantic versioning. The previous
scheme used 0.1.X versioning, where X was the CircleCI build number.

The version number 0.2.0 was chosen to differentiate it from that
process.

### Change List

- Tag the current version of the Iron Arachne website as v0.2.0
- Update the CI/CD configuration for CircleCI to reflect the new scheme
- Add the git commit hash as an additional Docker image tag
