function del()
{ 
    var msg = "您真的確定要刪除嗎？\n\n請確認！"; 
    if (confirm(msg)==true){ 
    return true; 
    }else{ 
    return false; 
    } 
} 