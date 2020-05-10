<?php
// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pmethod, $paction, array $pform, $pgames)
{
    nullAsEmpty($pform, "refid");
    nullAsEmpty($pform, "email");
    nullAsEmpty($pform, "rating");
    nullAsEmpty($pform, "review");
    
    $toptions = renderOptions($pgames, $pform["refid"]);
    foreach ($pgames as $pg) {
        if ($pg->id == $pform["refid"]){
            $tgamename = $pg->gamename;
        }
    }
    
    $tcontent = <<<PAGE
    <ul class="breadcrumb ss_breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="cranking.php">Ranking</a></li>
        <li><a href="game.php?id={$pform["refid"]}">{$tgamename}</a></li>
        <li class="active">Add a Review</li>
    </ul>
    <form class="form-horizontal" method="{$pmethod}" action="{$paction}">
		    <div class="form-group">
	           <label class="control-label col-xs-3" for="refid">Which game are you rating?</label>
	           <div class="col-xs-3">
		            <select class="form-control" id="refid" name="refid">
                        {$toptions}
		            </select>
		       </div>
            </div>
            <div class="form-group">
		        <label for="email" class="control-label col-xs-3">Email</label>
		        <div class="col-xs-9">
		            <input type="email" class="form-control" id="email" name="email" 
                      placeholder="Email" value="{$pform["email"]}">
		        </div>
		    </div>
            <div class="form-group">
	           <label class="control-label col-xs-3" for="rating">Rate the game</label>
	           <div class="col-xs-3">
		            <select class="form-control" id="rating" name="rating">
		                <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
		            </select>
		       </div>
            </div>
            <div class="form-group">
		        <label class="control-label col-xs-3" for="review">Review:</label>
		        <div class="col-xs-9">
		            <textarea rows="3" class="form-control" id="review" name="review" placeholder="Write game review..."></textarea>
		        </div>
		    </div>
            <div class="form-group">
		        <div class="col-xs-offset-3 col-xs-9">
		            <input type="submit" class="btn btn-primary" value="Submit">
		            <input type="reset" class="btn btn-default" value="Reset">
		        </div>
		    </div>
		</form>
PAGE;
    return $tcontent;
}

function createResponse($pformdata) {
    $tresponse = <<<RESPONSE
    <section class="panel panel-primary" id="Form Response" style="background-color: #eee; border-color: #ccc;">
        <div class="jumbotron">
            <h2>Thank You {$pformdata["email"]}</h2>
            <p class="lead">Your review has been submitted.</p>
            <a class="btn btn-success" href="game.php?id={$pformdata["refid"]}">Go Back</a>
        </div>
    </section>
RESPONSE;
    return $tresponse;
}

function processForm(array $pformdata): array {
    foreach ($pformdata as $tfield => $tvalue)
    {
        $pformdata[$tfield] = processFormData($tvalue);
    }
    
    $tvalid = true;
    if ($tvalid && empty($pformdata["refid"]))
    {
        $tvalid = false;
    }
    if ($tvalid && empty($pformdata["email"]))
    {
        $tvalid = false;
    }
    if ($tvalid && empty($pformdata["rating"]))
    {
        $tvalid = false;
    }
    if ($tvalid && empty($pformdata["review"]))
    {
        $tvalid = false;
    }
    if ($tvalid)
    {
        $pformdata["valid"] = true;
    }
    return $pformdata;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tgames = jsonLoadAllGames();

$taction = htmlspecialchars($_SERVER['PHP_SELF']);
$tmethod = "GET"; 
$tformdata = processForm($_REQUEST);

if(isset($tformdata["valid"]))
{
    unset($tformdata["valid"]);
    $tnewentry = "\r\n";
    $tnewentry .= json_encode($tformdata);
    file_put_contents("data/userreviews.json", $tnewentry, FILE_APPEND | LOCK_EX);
    $tpagecontent = createResponse($tformdata);
}
else {
    $tpagecontent = createPage($tmethod, $taction, $tformdata, $tgames);
}
    
$tpagetitle = "Review";
$tpagelead = "";
$tpagefooter = "";
    
// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
// Set the Three Dynamic Areas (1 and 3 have defaults)
if (! empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
    $tpage->setDynamic2($tpagecontent);
    if (! empty($tpagefooter))
        $tpage->setDynamic3($tpagefooter);
        // Return the Dynamic Page to the user.
        $tpage->renderPage();
?>