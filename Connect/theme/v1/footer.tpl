
 </div>
 
  
 </div>
 {if isset($msg)} {$msg} {/if}
 {php}
  global $hooks;
  $hooks->do_action('User_Footer');
 {/php}
 </body>
 </html>