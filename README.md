# PHP File Uploader :file_folder: :open_file_folder:
This is a utility script that helps in uploading the file to the server using PHP.
![People uploading files to server](https://cdni.iconscout.com/illustration/premium/thumb/upload-file-to-cloud-4487405-3722766.png)

## Installation
To start uploading files with this library, download the `file-uploader.php` file, then include it in your code :point_down:
```
require_once "file-uploader.php";
```
Or :point_down:
```
include_once "file-uploader.php";
```

## Arguments
After including the `file-uploader.php` in your code, you need to invoke `upload` function, passing to it the `$file` and `$uploadFolder` arguments :point_down:

```
$file = $_FILES["html_file_input"];
$uploadFolder = "my_uploading_folder";

upload ($file, $uploadFolder);
```
#### $file
This should be the first argument, it is the file you are trying to upload. This argument is mandatory.
> [!IMPORTANT]
> This argument mut be a file, otherwise the function returns an empty string `""` as shown in the next two code snippets :point_down:
```
// Calling upload() with no argument
upload ();
```
```
// Calling upload() with a non-file as an argument
$myVariable = "String type";
upload ($myVariable);
```

#### $uploadFolder
This should be the second argument of the function. It specifies the folder you want to save your file into. This is an option argument.
> [!NOTE]
> If not specified the script will attempt to upload the file to the `current-working-directory`.

## Successful Upload
Upon successfull upload of the file, this function returns name of the file with it's extension appended to it, example `uploaded-document.pdf`. Note in the code snippet below, the `$fileName` will have name of the uploaded file. You can further-use this filename in your code, for-instance saving it to the database, etc :point_down:
```
$file = $_FILES["html_file_input"];

// The $fileName below will have name of the file uploaded
$fileName = upload ($file);
```

## Unsuccessful Upload
If upload was not successful, the function will return an empty string `""`. Note in the code snippet below, the `$fileName` will have an empty string stored in it. You can proceed with the execution of your code depending on this value, for-instance prompting users that file upload failed, :point_down:
```
// The upload() function expects `a file as the first argument`
// Since we are calling the function with a string as the first argument
// Then upload process will fail, and the upload() function returns an empty string :point_down:

$myVariable = "String type";
$fileName = upload ($myVariable); // empty string ""
```