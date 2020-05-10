<?php
// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pmethod, $paction, array $pform)
{
    nullAsEmpty($pform, "inputEmail");
    nullAsEmpty($pform, "inputPassword");
    nullAsEmpty($pform, "confirmPassword");
    nullAsEmpty($pform, "firstName");
    nullAsEmpty($pform, "lastName");
    nullAsEmpty($pform, "phoneNumber");

    nullAsEmpty($pform, "err-firstName");

    $tcontent = <<<PAGE
<form class="form-horizontal" method="{$pmethod}" action="{$paction}">
		    <div class="form-group">
		        <label for="inputEmail" class="control-label col-xs-3">Email</label>
		        <div class="col-xs-9">
		            <input type="email" class="form-control" id="inputEmail" name="inputEmail" 
                      placeholder="Email" value="{$pform["inputEmail"]}">
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="inputPassword" class="control-label col-xs-3">Password</label>
		        <div class="col-xs-9">
		            <input type="password" class="form-control" id="inputPassword" 
                     name="inputPassword" placeholder="Password" value="{$pform["inputPassword"]}">
		        </div>
		    </div>
            <div class="form-group">
		        <label class="control-label col-xs-3" for="confirmPassword">Confirm Password:</label>
		        <div class="col-xs-9">
		            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                       placeholder="Confirm Password" value="{$pform["confirmPassword"]}">
		        </div>
		    </div>
            <div class="form-group">
                <label class="control-label col-xs-3" for="firstName">First Name:</label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="firstName" name="firstName"
                    placeholder="First Name" value="{$pform["firstName"]}">
                    {$pform["err-firstName"]}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3" for="lastName">Last Name:</label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="lastName" 
                    name="lastName" placeholder="Last Name" value="{$pform["lastName"]}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3" for="phoneNumber">Phone:</label>
                <div class="col-xs-9">
                    <input type="tel" class="form-control" id="phoneNumber" 
                     name="phoneNumber" placeholder="Phone Number" value="{$pform["phoneNumber"]}">
                </div>
            </div>
            <div class="form-group">
	           <label class="control-label col-xs-3">Date of Birth:</label>
	           <div class="col-xs-3">
		            <select class="form-control">
		                <option>Date</option>
		            </select>
		       </div>
		       <div class="col-xs-3">
		            <select class="form-control">
		                <option>Month</option>
		            </select>
		       </div>
		       <div class="col-xs-3">
		            <select class="form-control">
		                <option>Year</option>
		            </select>
		       </div>
            </div>
            <div class="form-group">
		        <label class="control-label col-xs-3" for="postalAddress">Address:</label>
		        <div class="col-xs-9">
		            <textarea rows="3" class="form-control" id="postalAddress" placeholder="Postal Address"></textarea>
		        </div>
		    </div>
            <div class="form-group">
                <label class="control-label col-xs-3" for="ZipCode">Post Code:</label>
                <div class="col-xs-9">
                    <input type="text" class="form-control" id="ZipCode" placeholder="Post Code">
                </div>
            </div>
            <div class="form-group">
		        <label class="control-label col-xs-3">Gender:</label>
		        <div class="col-xs-2">
		        <label class="radio-inline">
		                <input type="radio" name="genderRadios" value="male"> Male
		        </label>
		        </div>
		        <div class="col-xs-2">
		        <label class="radio-inline">
		                <input type="radio" name="genderRadios" value="female"> Female
		        </label>
		        </div>
		    </div>
            <div class="form-group">
		        <div class="col-xs-offset-3 col-xs-9">
		            <label class="checkbox-inline">
		                <input type="checkbox" value="news" checked> Send me latest news and updates.
		            </label>
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-xs-offset-3 col-xs-9">
		            <label class="checkbox-inline">
		                <input type="checkbox" value="agree" checked>  I agree to the <a href="#">Terms and Conditions</a>.
		            </label>
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-xs-offset-3 col-xs-9">
		            <div class="checkbox">
		                <label><input type="checkbox"> Remember me</label>
		            </div>
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

function createResponse(array $pformdata)
{
    $tresponse = <<<RESPONSE
		<section class="panel panel-primary" id="Form Response">
				<div class="jumbotron">
					<h1>Thank You {$pformdata["firstName"]} {$pformdata["lastName"]}</h1>
					<p class="lead">Your account has been created.</p>
					<p class="lead">You will receive weekly updates to {$pformdata["inputEmail"]} </p>
				</div>
		</section>
RESPONSE;
    return $tresponse;
}

function processForm(array $pformdata): array
{
    foreach ($pformdata as $tfield => $tvalue)
    {
        $pformdata[$tfield] = processFormData($tvalue);
    }
    $tvalid = true;
    if ($tvalid && empty($pformdata["firstName"]))
    {
        $tvalid = false;
        $pformdata["err-firstName"] = "<p id=\"help-firstName\" class=\"help-block\">First Name Required</p>";
    }
    if ($tvalid && empty($pformdata["inputPassword"]))
    {
        $tvalid = false;
    }
    if ($tvalid && empty($pformdata["confirmPassword"]))
    {
        $tvalid = false;
    }
    if ($tvalid && $pformdata["confirmPassword"] != $pformdata["inputPassword"])
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
$taction = htmlspecialchars($_SERVER['PHP_SELF']);
$tmethod = "GET";
$tformdata = processForm($_REQUEST) ?? array();

if (isset($tformdata["valid"]))
{
    $tpagecontent = createResponse($tformdata);
}
else
{
    $tpagecontent = createPage($tmethod, $taction, $tformdata);
}

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tindexpage = new MasterPage("Data Entry");
$tindexpage->setDynamic2($tpagecontent);
$tindexpage->renderPage();

?>