<?php
   require_once('loader.php');
   require_once('send_push_notification_message.php');

    $resultUsers = getAllUsers();

    if ($resultUsers != false)
        $NumOfUsers = mysql_num_rows($resultUsers);
    else
        $NumOfUsers = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                
            });
            function sendPushNotification(){
                var data = $('form#sendForm').serialize();
                $('form#sendForm').unbind('submit');                
                $.ajax({
                    url: "send_push_notification_message.php",
                    type: 'GET',
                    data: data,
                    beforeSend: function() {
                         
                    },
                    success: function(data, textStatus, xhr) {
                          $('.push_message').val("");
                          $('.app_version').val("");
                    },
                    error: function(xhr, textStatus, errorThrown) {
                          $('.push_message').val(textStatus);
                    }
                });
                return false;
            }
        </script>
        <style type="text/css">
             
            h1{
                font-family:Helvetica, Arial, sans-serif;
                font-size: 24px;
                color: #777;
            }
            div.clear{
                clear: both;
            }
             
            textarea{
                float: left;
                resize: none;
            }
             
        </style>
    </head>
    <body>
         
         
        <table  width="910" cellpadding="1" cellspacing="1" style="padding-left:10px;">
         <tr>
           <td align="left">
              <h1>Number of Devices Registered: <?php echo $NumOfUsers; ?></h1>
              <hr/>
           </td>
          </tr> 
          <tr>
            <td align="center">
              <table width="100%" cellpadding="1"
                        cellspacing="1"
                        style="border:1px solid #CCC;" bgcolor="#f4f4f4">

         <tr><td colspan='2'> </td></tr>
         <tr>
                <td align="left">
                     <form id="sendForm" name="" method="post" onSubmit="return sendPushNotification()">
                        <label><b>Send message to divece with app version:</b></label>
                         <span> <input type="input" name="version" value="" class="app_version"/></span>
                        <div class="send_container">                                
                            <textarea rows="3"
                                   name="message"
                                   cols="25" class="push_message"
                                   placeholder="Type push message here"></textarea>
                            <input type="submit" 
                                      value="Send Push Notification" onClick=""/>
                        </div>
                    </form>
                 </td>
                </tr>
                </table>
            </td>
          </tr>  
        </table>
         
         
    </body>
</html>