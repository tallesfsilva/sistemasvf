



export const noti = {


    init : (error, msg) =>{

        const notification = new $.peekABar({
                html: msg,             
                delay: 3000,
                autohide: true,             
                padding: '1em',
                backgroundColor: error? '#A70000' : '#00BB07',            
                animation: {
                type: 'fade',           
                duration: 'slow'
                 },             
                cssClass: 'notification-msg',
                opacity: '1',
                position: 'top',           
                closeOnClick: false             
                });
                notification.show();

    }




}