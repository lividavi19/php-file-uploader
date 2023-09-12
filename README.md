# PHP File Uploader
This is a utility script that helps in uploading the file to the server using PHP.
![People uploading files to server](https://cdni.iconscout.com/illustration/premium/thumb/upload-file-to-cloud-4487405-3722766.png)

## Installation
To start uploading files with this library, download the `file-uploader.php` file, then include it in your code. Such as below ;
```
require_once "file-uploader.php";
```
Or;
```
include_once "file-uploader.php";
```

## Arguments
After including the `file-uploader.php` in your code, you need to invoke `upload` function by passing the `$file` and `$uploadFolder` arguments to it as shown below;

```
upload ($file, $uploadFolder);
```

#### $file
This should be the first argument, it is the file you are trying to upload. This argument is mandatory.

#### $uploadFolder
This should be the second argument of the function. It specifies the folder you want to save your file into. This is an option argument, if not specified the script will attempt to upload the file to the `current-working-directory`.

## Successful Upload
Upon successfull upload of the file, this function returns name of the file with it's extension appended to it, example `uploaded-document.pdf`. You can further-use this filename in your code, for-instance saving it to the database etc.

## Unsuccessful Upload
If upload was not successful, the function will return an empty string `""`