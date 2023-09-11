# PHP File Uploader
This is a utility script that helps in uploading the file to the server using PHP.

## Installation
Include this file in your code.
Example;
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
upload ($file, $uploadFolder)
```

#### $file
This should be the first argument, it is the file you are trying to upload.
This argument is mandatory.

#### $uploadFolder
This should be the second argument of the function.
It specifies the folder you want to save your file into. This is an option argument, if not specified the script will attempt to upload the file to the `current-working-directory`.

## Successful Upload
Upon successfull upload of the file, this function returns the name of the file `$fileName` with it's extension appended to it. Such as `uploaded-document.pdf`
You can further use this `$fileName` in you code Ex. saving it into the database etc.

## Unsuccessful Upload
If upload was not successful, the function will return an empty string `""`