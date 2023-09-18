# PHP File Uploader :file_folder: :open_file_folder:
This is a utility script that helps in uploading files to the server using PHP programming language.
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
After including the `file-uploader.php` in your code, you need to invoke `upload()` function, passing to it the `$file` argument and an optional `$uploadFolder` argument :point_down:

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


## Configurations
There are few a stuffs you need to do to configure the library to work depends on your specific uses cases. Things like setting the specifying `file types` and also  `maximum file size` allowed for upload.

### Allowed File Types
By default the library supports upload of `PNG JPG JPEG` images and `PDF` documents. But your project might be supporting different range of file types than the default ones.
To support different file types follow steps below :point_down:
- Open `file-uploader.php` file
- Locate `$EXTENSIONS_ALLOWED` variable in that file
- Initialize it to an array of strings, representing file types you need to support
- Following example supports only `PNG JPG JPEG` image files :point_down:
```
$EXTENSIONS_ALLOWED = ["PNG", "JPG", "JPEG"];
```

### Maximum File Size
Default maximum size allowed is set to 2MB for this library. To change it to a different size do the following :point_down:
- Open `file-uploader.php` file
- Locate `$MAX_SIZE_ALLOWED` variable in that file
- Change the number outside the brackets to a maximum file size (in MB) you want to allow
- Following example set maximum size allowed for upload to 10MB :point_down:
```
$MAX_SIZE_ALLOWED = 10 * (1024 * 1024);
```


## Successful Upload
Upon successfull upload of the file, this function returns name of the file with it's extension appended to it, for example `uploaded-document.pdf`.
In code snippet below, the `$fileName` will have name of the uploaded file. You can further-use this filename in your code, for-instance saving it to the database, etc :point_down:
```
$file = $_FILES["html_file_input"];

// The $fileName below will have name of the file uploaded
$fileName = upload ($file);

if ($fileName) {
	// Print info about uploaded file
	echo "Uploaded file is {$fileName}";
} else {
	// Prompt client that upload failed
	echo "Upload failed!";
}
```
:point_right: :point_right: :point_right:
_Uploaded file is **uploadedFileName.png**_


## Unsuccessful Upload
If upload was not successful, the function will return an empty string `""`
In code snippet below, the `$fileName` will have an empty string stored in it. You can proceed with the execution of your code depending on this value, for-instance prompting users that file upload failed :point_down:
```
// The upload() function expects a file as the first argument
// Since we are calling the function with a string as the first argument
// Then upload process will fail, and the upload() function returns an empty string

$myVariable = "String type";
$fileName = upload ($myVariable); // empty string ""

if ($fileName) {
	// Print info about uploaded file
	echo "Uploaded file is {$fileName}";
} else {
	// Prompt client that upload failed
	echo "Upload failed!";
}
```
:point_right: :point_right: :point_right:
_Upload failed!_