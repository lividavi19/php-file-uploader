# PHP file uploader
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

## Usage
Invoke `upload ($file, $uploadFolder)` function passing the following arguments;
### $file
This should be the first argument, it is the file you are trying to upload.
This argument is mandatory.

### $uploadFolder
This should be the second argument of the function.
It specifies the folder you want to save your file into. This is an option argument, if not specified the script will attempt to upload the file to the `current-working-directory`.

## Upload success
Upon successfull upload of the file, this function returns the name of the file `$fileName` with it's extension appended to it. Such as `uploaded-document.pdf`
You can further use this `$fileName` in you code Ex. saving it into the database etc.

## Upload fail
If upload was not successful, the function will return an empty string `""`