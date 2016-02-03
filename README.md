DDNS53
=======

DDNS53 is a URL-based PHP script designed to update your server's external hostname (e.g. server.example.com) using Amazon's Route 53 DNS service. It works automatically by calling the script via a URL, using Amazon's IAM service to authenticate, then changing the hostname value to the defined IP address. Additionally, it perfectly fits in with Synology NAS servers.

__In other words, DDNS53 helps connect your server's ever-changing IP address to a domain name.__

To use this script, here are the steps you need to follow:

1. Place in a locally accessible PHP server.
2. Using the URL-method, call the script (usage below).
3. Wait for the magic to begin!

## Retrieve Variables
These are the descriptions of the variables that you must fill before calling the script. Examples are located next to the description. Please follow the exact format unless you know what you're doing. __If you need help, feel free to open an issue on GitHub!__

##### DDNS53 Authentication
1. __id__ - Access Key ID (e.g. AKIRIQC23QKODRLJRV4A)
2. __secret__ - Secret Access Key (e.g. Ikal5f2Hrk#XmiT5KAAnNj3OBd0DAoN9b1PFnFit)
3. __zone__ - Hosted Zone ID (e.g. Z1W6QQYB7WYB0E)

##### DDNS53 Configuration
1. __hostname__ - Hostname (e.g. server.example.com)
2. __type__ - Host Type (e.g. A, AAAA)
3. __newip__ - New IP (e.g. 122.23.34.128)

##### DDNS53 Optional Settings
1. __synology__ - Enables Synology Error Messages (0 or 1, optional)
2. __debug__ - Enabled Debug Mode (optional)

## Get Amazon Access Keys
Coming Soon!

## Get Amazon Hosted Zone ID
Coming Soon!

## How to Use this Script
There are plenty of ways on how to use this script, but to properly access this script, the authentication variables and the configuration variables must be set when you call this script. I have also included methods to enable Synology mode and debug mode for those who need them. Here is one example:

```
http://127.0.0.1/ddns53.php?id=__id__&secret=__secret__&zone=__zone__&hostname=__hostname__&type=__type__&newip=__newip__&synology=__synology__&debug=__debug__
```

## Credits and Appreciation
The idea for this script came from [Holger Eilhard](http://holgr.com/)'s php-ddns53 and the required library comes from Dan Myers's [Amazon Route 53 PHP Class](http://sourceforge.net/projects/php-r53/). Please credit them for their work and appreciation.