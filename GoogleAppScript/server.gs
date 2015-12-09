
function doGet(e) {
  return HtmlService.createHtmlOutputFromFile('form.html');
}

function uploadFiles(form) {
  
  try {
    
    //---請將「上傳資料夾」修改為要存放的資料夾名稱----
    var dropbox = "uploads"; 
    //----------------------------------------------
    var folder, folders = DriveApp.getFoldersByName(dropbox);
    
    if (folders.hasNext()) {
      folder = folders.next();
    } else {
      folder = DriveApp.createFolder(dropbox);
    }
    
    var blob = form.myFile;    
    var file = folder.createFile(blob);    
    var id = file.getId(); 
    file.setDescription(id);
    
    return id;  
    
  } catch (error) {
    
    return error.toString();
  }
  
}
