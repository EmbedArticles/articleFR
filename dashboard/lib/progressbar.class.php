<?php

/*
 * @Author: Vance Walsh, vance@vancewalsh.com
 * @copyright: You may use, and redistribute this as needed.
 * @warranty: I make no claims that this will work properly and I am not responsible for any issues you have.
 */

//creates a progress bar inside of an iframe.
//if your process script is going to run for a long time make sure to change the set_time_limit();

error_reporting(1);

class ProgressBar
{
    /*
     * $loop keeps track of each time you start a new progress set. a progress set would be something like this:
     * -in your script you have multiple (a known, fixed number) of while loops and an unknown total of iterations per loop
     * -the loop var will keep track every time you submit a progress bar update (this->progress(...)) and
     *   will keep the counter at the correct percent.
     * -an example: your script has 4 loops each with an unknown number of ->progress(...) requests
     * -you set it so each progress call has the percentModifier set to 100/4 or 25.
     * -everytime the count == total, loop will increment
     * -on the next call to progress, the loop will add loop*25 to the percent being output
     */
    private $loop = 0;
    
    //running total of bytes output to the browser
    private $output_buffer_padding = 0;
    
    //total bytes to force browser to render progress bar.
    private $output_buffer_padding_total = 512;
    
    //to save bandwidth and memory, if the percent calculates to the same this time around. don't send out the progress bar update.
    private $last_percent = 0;
    
    //if true, output normally, if false, don't output and return right away.
    private $output = true;
    
    /*
     * call this at the beginning of your script, keeping this var global if possible, after any headers you need to output.
     * lets see if we can get the output progress working nicely.
     */
    public function ProgressBar($output = true)
    {
        if($otuput == true)
        {
            //setup the output buffer so everything should be kicked out asap. this doesn't stop the browser from buffering or caching our progress.
            @apache_setenv('no-gzip', 1);
            @ini_set('zlib.output_compression', 0);
            @ini_set('implicit_flush', 1);
            //for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
            ob_implicit_flush(1);
        }
        
        $this->output = $output;
    }
    
    /*
     * @msg = custom message to display
     * @count = current count to be used to calculate the percentage
     * @total = total to be used with count to calculate the percentage
     * @percentModifier = allows you to run multiple loops, just tell it the fraction of each loop your running ie 
     */
    public function progress($msg = "", $count = 0, $total = 1, $percentModifier = 100)
    {
        //return immediately.
        if($this->output == false)
            return;
        
        if($msg != 'pb-start' && $msg != 'pb-end' && $msg == '')
        {
            //increment due to the typical nature of loops and how they ususally increment last.
            $count++;

            //calculate the percent of count/total * (number of loops/100) and add the current loop * (number of loops / 100)
            $percent = floor($count / $total * $percentModifier) + abs($this->loop) * $percentModifier;

            if($percent == $this->last_percent)
            {
                return;
            }
            
            //they have completed one entire loop, while or for statement.
            if($count >= $total)
            {
                $this->loop++;
            }
        }
        if($msg == 'pb-start'){
            $percent = 0;
        }
        if($msg == 'pb-end'){
            $percent = 100;
        }
        
        $bar = "<div style='width: $percent%; height: 20px; background: #000; position:absolute; left: 0; top: 0;'></div><p style='position: absolute; top: -16px; left: 0; padding: 0 2px 0 2px; color:#000; background: #fff; height: 20px;'>$percent%</p>";
        
        if($msg == 'pb-start')//echo out the start tags and then the progress elements.
        {
            $msg = '<p style="padding: 0; margin: 0; position: relative;">loading...</p><div style="width: 400px; padding-right: 35px; height: 20px; border: 2px solid black; position: relative; margin-left: 5px;">';
        }
        else if($msg == 'pb-end')//output the end
        {
            $msg = $bar."</div>";
        }
        else if($msg != "")//output a custom message.
        {
            $msg = $msg;
        }
        else
        {
            $msg = $bar;
        }
        
        
        $this->last_percent = $percent;
        
        //we can stop outputting now that we've got about 1kb out.
        if($this->output_buffer_padding > $this->output_buffer_padding_total)
        {
            echo "$msg";
            flush();
        }
        else
        {
            //add the output length
            $this->output_buffer_padding .= strlen($msg);
            
            echo "$msg".str_repeat(" ", $this->output_buffer_padding_total - $this->output_buffer_padding);//add extra bytes to stop most browsers from buffering
            $this->output_buffer_padding .= $this->output_buffer_padding_total - $this->output_buffer_padding;
            flush();
        }
        
        flush();
        ob_flush();    
        //print ob_get_clean();    
        //end the flushing of the buffer
        if($this->loop >= 100/$percentModifier && $count >= $total)
        {
            ob_end_flush();
        }
    }
}

?>