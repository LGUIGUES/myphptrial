# Trial

## Fork the project, commit and push your changes on your repository  




The page `index.php` is used to collect a file from the user and process it. 
The goal is to add features to the barebone code.

## Control  

- The size of the file should not exceed 2MB
- The page should only accept files with the following extensions : `csv`, `json`  

## Processing the file  

### CSV   
  
In case of a CSV submition, write a function to convert the file content to a JSON format.

example : 
The following CSV 
``` 
name,surname,city   
John,Doe,San Diego
Ernest,Hemingway, La Havane
...
```
should output :  
```
[
  {
    "name": "John",
    "surname": "Doe",
    "city": "San Diego"
  },
  {
    "name": "Ernest",
    "surname": "Hemingway",
    "city": "La Havane"
  }
] 
```

### JSON  & checks
 
In case of a JSON submition (or once the CSV is converted), write a function to check the presence of the following required fields: `name`, `surname`, `city`.  
If one or more field is missing, display an error message.  


## Posting the content  

Once the file is processed and you have a valid JSON output, perform an HTTP POST request to `https://phptrialapi.netlify.app`  with the following structure:  
```
{
  "data": [] // The valid output in JSON format
  "token": ""  // you will find the token in init.php
}
```

Display a message with the informations contained in the response  

## UX

Use HTML & CSS to customize the interface, error messages etc...

***

**You are free to use any CSS framework and PHP module you want**
*** 

