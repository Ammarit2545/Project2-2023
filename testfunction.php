<?php
// Replace 'Project2-2023' with the folder name you want to select
$selectedFolder = '../';

// Get the path of the selected folder
$selectedFolderPath = __DIR__ . '/' . $selectedFolder;

// Use dirname twice to get the mother folder path
$motherFolderPath = dirname(dirname($selectedFolderPath));

// Use basename to get the name of the mother folder
$motherFolderName = basename($motherFolderPath);

// Display the name of the mother folder
echo "The mother folder is: " . $motherFolderName . "<br>";

?>
