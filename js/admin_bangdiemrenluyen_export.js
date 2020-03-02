$('.btn-download').click(function(){
    ShowDownloadMessage();
});

function ShowDownloadMessage()
{
    loadereffectshow();
    window.addEventListener('focus', HideDownloadMessage, false);
}

function HideDownloadMessage(){
    window.removeEventListener('focus', HideDownloadMessage, false);                   
    loadereffecthide();
}