# 360Constest

360Constest is an open source online platform for run contests that is capable to run sites similar to 99design,designcrowd,zenlayout,logobids,etc. It is written in CakePHP with MySQL.

> This is project is part of Agriya Open Source efforts. 360Constest was originally a paid script and was selling around 11000 Euros. It is now released under dual license (OSL 3.0 & Commercial) for open source community benefits.

![trainr_banner](https://user-images.githubusercontent.com/4700341/47853825-02074100-de06-11e8-9c92-7a3d38c7b9cf.png)

## Support

360Constest is an open source online platform for run contests project. Full commercial support (commercial license, customization, training, etc) are available through [360Contest platform support](https://www.agriya.com/products/contest-software)

Theming partner [CSSilize for design and HTML conversions](http://cssilize.com/)

## Features

### Image Contests

Image contests for image resources. Participants can send their image by uploading it 360contest.

### Video Contests

Contest holder can post the contests for video resources. Participants can send their videos by uploading that to Vimeo or Youtube through 360contest. Uploading can be direct upload or normal upload.

### Contest listing fee

Collected from contest holder when listing the contests for day wise.

### Escrow

Site can act as escrow and when agreed, participant will be paid after taking site commission; when canceled, the prize amount will be refunded back to contest holder

### Widget

Set up the site for earn some revenue from adding widget in the site footer. Settings are manage in admin panel.

### Affiliate

User can associate/refer our site to a different network thereby referred user can earn commission.

## Getting Started

### Prerequisites

#### For deployment

* MySQL
* PHP >= 5.5.9 with OpenSSL, PDO, Mbstring and cURL extensions
* Nginx (preferred) or Apache

### Setup

* Needs writable permission for `/tmp/` , `/media/` and `/webroot/` folders found within project path
* Database schema 'app/Config/Schema/sql/360contest_with_empty_data.sql'
* Cron with below:
```bash
# Common
*/2 * * * * /{$absolute_project_path}/app/Console/Command/cron.sh 1 >> /{$absolute_project_path}/app/tmp/error.log 2 >> /{$absolute_project_path}/app/tmp/error.log
```

### Contributing

Our approach is similar to Magento. If anything is not clear, please [contact us](https://www.agriya.com/contact).

All Submissions you make to 360contest through GitHub are subject to the following terms and conditions:

* You grant Agriya a perpetual, worldwide, non-exclusive, no charge, royalty free, irrevocable license under your applicable copyrights and patents to reproduce, prepare derivative works of, display, publicly perform, sublicense and distribute any feedback, ideas, code, or other information ("Submission") you submit through GitHub.
* Your Submission is an original work of authorship and you are the owner or are legally entitled to grant the license stated above.


### License

Copyright (c) 2014-2018 [Agriya](https://www.agriya.com/).

Dual License (OSL 3.0 & [Commercial License](https://www.agriya.com/contact))
