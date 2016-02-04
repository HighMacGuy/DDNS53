DDNS53
=======

DDNS53 is a URL-based PHP script designed to update your server's external hostname (e.g. server.example.com) using Amazon's Route 53 DNS service. It works automatically by calling the script via a URL, using Amazon's IAM service to authenticate, then changing the hostname value to the defined IP address. Additionally, it perfectly fits in with Synology NAS servers.

__In other words, DDNS53 helps connect your server's ever-changing IP address to a domain name.__

To use this script, here are the steps you need to follow:

1. Place the files in a locally-accessible PHP server.
2. Call the ddns53.php script with the variables (shown below)
3. Try accessing the external hostname and see the magic!

## Retrieve Variables
These are the descriptions of the variables that you must fill before calling the script. Examples are located next to the description. Please follow the exact format unless you know what you're doing. __If you need help, feel free to open an issue on GitHub!__

##### DDNS53 Authentication
1. __id__ - Access Key ID (e.g. AKIAIOSFODNN7EXAMPLE)
2. __secret__ - Secret Access Key (e.g. wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY)
3. __zone__ - Hosted Zone ID (e.g. Z111111QQQQQQQ)

##### DDNS53 Configuration
1. __hostname__ - Hostname (e.g. server.example.com)
2. __type__ - Host Type (e.g. A, AAAA)
3. __newip__ - New IP (e.g. 192.0.2.235, 2001:0db8:85a3:0:0:8a2e:0370:7334)

##### DDNS53 Optional Settings
1. __synology__ - Enables Synology Error Messages (0 or 1, optional)
2. __debug__ - Enabled Debug Mode (0 or 1, optional)

## Get Amazon Access Keys
1. Head to https://console.aws.amazon.com/iam/home
2. On the sidebar, click on the __Users__ link
3. Then click the blue __Create New Users__ button
4. In the first field, type in a username
5. Keep __Generate an access key for each user__, checked
6. Then, click __Create__ (bottom right hand corner)
7. Click on the __Show User Security Credentials__ link
8. Fill out the __id__ and __secret__ fields

NOTE: You may copy these security credentials or click the __Download Credentials__ button. If you lose these credentials, you can revoke access to the user then create another one.

## Get Amazon Hosted Zone ID
1. Head to https://console.aws.amazon.com/route53/home#hosted-zones:
2. Find the "Hosted Zone ID" column that corresponds to the domain name.
3. Fill out the __zone__ field with the matching Zone ID.

NOTE: If you do not have a Hosted Zone, please create one manually. Then link the nameserver's with your domain name. You can even transfer your domain to Amazon (even easier)!

NOTE 2: Don't forget to create a Record Set with either an A record (IPv4 address) or an AAAA record (IPv6 address). The "Name" column fills in the __hostname__ field and the "Type" column fills in the __type__ field.

NOTE 3: When you copy the "Name" to the __hostname__ field, remember not to include the LAST DOT. For example, instead of using __server.example.com.__ (with period), use __server.example.com__ (without period).

## How to Use this Script
There are plenty of ways on how to use this script, but to properly access this script, the authentication variables and the configuration variables must be set when you call this script. I have also included methods to enable Synology mode and debug mode for those who need them. Here is an example:

```
http://127.0.0.1/ddns53.php?id=__ID__&secret=__SECRET__&zone=__ZONE__&hostname=__HOSTNAME__&type=__TYPE__&newip=__NEWIP__&synology=__SYNOLOGY__&debug=__DEBUG__
```

NOTE: __127.0.0.1__ is an example. Each server's local IP address is UNIQUE and YOU MUST manually retrieve it. Usually the values start with __192.168.1.2__, but it could depend on each server and network configuration.

NOTE 2: The capitalized words (including the underscores) in-between the URL are the variables you need to replace. Just follow the variable examples above!

## Credits and Appreciation
The idea for this script came from [Holger Eilhard](http://holgr.com/)'s php-ddns53 and the required library from Dan Myers's [Amazon Route 53 PHP Class](http://sourceforge.net/projects/php-r53/). Please credit them for their work and appreciation. Thanks!