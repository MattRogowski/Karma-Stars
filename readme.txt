Name: Karma Stars
Description: Earn 'karma' and collect stars for posting.
Website: https://github.com/MattRogowski/Karma-Stars
Author: Matt Rogowski
Authorsite: https://matt.rogow.ski
Version: 1.1.1
Compatibility: 1.6.x, 1.8.x
Files: 4 (plus 18 images)
Templates added: 4
Template changes: 4
Database tables added: 1
Database columns added: 0

Information:
This plugin will show stars, or 'karma', based on post count.

To Install:
Upload ./inc/plugins/karmastars.php to ./inc/plugins/
Upload ./inc/languages/karmastars.lang.php to ./inc/languages/english/
Upload ./images/karmastars/ and its contents to ./images/
Upload ./admin/modules/user/karmastars.php to ./admin/modules/user/
Upload ./inc/languages/english/admin/user_karmastars.lang.php to ./inc/languages/english/admin/
Go to ACP > Plugins > Activate

Change Log:
31/03/12 - v0.1 -> Initial 'beta' release.
22/04/12 - v0.1 -> v1.0 -> Added ability to change how many Karma levels there are. To upgrade, reupload ./inc/plugins/karmastars.php, ./admin/modules/user/karmastars.php and ./inc/languages/english/admin/user_karmastars.lang.php
25/08/14 - v1.0 -> v1.1 -> MyBB 1.8 compatible. Fixed bug with 'next karma' on list view. To upgrade, deactivate, reupload ./inc/plugins/karmastars.php, activate.
28/12/16 - v1.1 -> v1.1.1 -> Added missing language string for admin permission. To upgrade, reupload ./inc/plugins/karmastars.php and ./inc/languages/english/admin/user_karmastars.lang.php

Copyright 2016 Matthew Rogowski

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 ** http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.