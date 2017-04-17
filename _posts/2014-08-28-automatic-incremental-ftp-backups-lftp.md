---
layout: article
title: Automatic incremental FTP backups with LFTP
date: 2014-08-28 13:24:00 +0000
description: LFTP is a command line FTP client that comes equipped with some rather useful features. Features that make it quite suitable for remote web server incremental back-ups. In conjunction with with bash scripting and a scheduled cron task entry it becomes a fairly robust automated solution.
categories: Linux
permalink: articles/automatic-incremental-ftp-backups-lftp.html
---
LFTP is a command line FTP client that comes equipped with some rather useful features. Features that make it quite suitable for remote web server incremental back-ups. In conjunction with with bash scripting and a scheduled cron task entry it becomes a fairly robust automated solution.

While RSync over SSH may be a better solution most of the time, it is not viable for those who host their applications on shared servers that do not allow SSH access.

### Installation

Installing the _LFTP_ client via the _APT_ package manager on the local machine.

```
$ sudo apt-get install lftp
```

As mentioned above, LFTP is a command line utility. It therefore does not come with any sort of graphical user interface.

### The Bash script

Bash scripting will be employed take care of running the actual synchronization process by supplying the appropriate login details and initiating the necessary command.

```
username='syncuser'
password='p@$w0rd'
ipAddress='192.168.65.13'
port='21'
lftp -e "mirror --only-newer --parallel=4 /home//Backup /var/www; exit" -u $username,$password -p 2121 $ipAddress

```

Where ftp `username`, `password` and `port` are the credentials of the remote server, and the `ipAddress` is it's numeric IP address.

The `--only-newer` option instructs _LFTP_ to only download files that have a newer modified date to that of the target file in the local back-up directory. This is to ensure that only files that have been modified after the last back-up are downloaded, and that unchanged files are not. This option dramatically speeds up the back-up process, reduces network transfer overheads and saves time to!

The `--parallel` option specifies how many concurrent file transfers the take place during the back-up process. This option must be set with caution, as too many concurrent transfers could actually land up slowing the entire process down.

This bash script now needs to be saved somewhere on the local machine, so that it can be run in future. As a suggestion, perhaps in the `~/Scripts/` sub-folder in the home directory would be most appropriate. Take care not to omit the file's suffix `.sh` from it's name, for example: `~/sync/backup.sh`.

### Scheduling the cron job

Automation will be managed by the native Ubuntu cron system. Cron tasks are usually defined in a file called _crontab_ in the `/etc` directory. To register this back-up script as a scheduled cron task, open the _crontab_ file in the _Nano_ text editor.

```
$ sudo nano /etc/crontab
```

Or in the _Gedit_ text editor, if more preferable.

```
$ sudo gedit /etc/crontab
```

Add the following line to the end of the file.

```
10 01 * * * <example_username> /path/to/script/backup.sh</example_username>
```

The `<example_username></example_username>`must obviously be set to the appropriate username of the user account whom this task is to be run under. The path must also be set to that of the bash script.

As per the scheduled task added to the _crontab_ file above, the back-up script will be executed daily at 01:10 in the morning.

For more information about cron time formatting, please see this [useful Ask Ubuntu.](/web/20150225143901/http://askubuntu.com/questions/2368/how-do-i-set-up-a-cron-jobhttp://)

### Conclusion

While not a perfect solution, this is a viable option for users who use shared hosts that do not allow SSH access. It must be noted that this script will only add files to the back-up destination and not delete them. Therefore if a file is deleted from the source it wont be automatically deleted from the back-up destination.

### References

- [http://linux.die.net/man/1/lftp](/web/20150225143901/http://linux.die.net/man/1/lftp)
