<?php

require_once("oo_bll.inc.php");
require_once("oo_pl.inc.php");

function renderGameOverview(BLLGame $pg)
{
    $timgref = "img/game/{$pg->id}.png";
    $timg = $timgref;
    $buttontype = "warning";
    if ($pg->score>7) {
        $buttontype = "success";
    } else if ($pg->score<4) {
        $buttontype = "danger";
    }
    $toverview = <<<OVERVIEW
    <div class="row">
    <h2>Game Review</h2>
        <div class="col-lg-4">
            <img src="{$timg}" class="img-responsive">
        </div>
        <div class="col-lg-8">
            <div class="well">
                <h1 style="margin-top:0px; margin-bottom:0px;">{$pg->gamename}</h1>
            </div>
            <h1><b>Our Score: </b><span class="btn btn-lg btn-{$buttontype}"><b>{$pg->score}</b></span></h1>
            <h3><b>Developer:</b> {$pg->developer}</h3>
            <h3><b>Genre(s):</b> {$pg->genres}</h3>
            <h3><b># of players:</b> {$pg->multiplayer}</h3>
            </div>
        </div>
OVERVIEW;
    return $toverview;
}



function renderTable($pgames) 
{
    usort($pgames,function (BLLGame $a,BLLGame $b)
    {
        $tsort = $b->score <=> $a->score;
        return $tsort;
    });
    
    $trowdata = "";
    foreach ($pgames as $tg) {
        $trowdata .= <<<ROW
        <tr>
            <td>{$tg->score}</td>
            <td>{$tg->gamename}</td>
            <td>{$tg->developer}</td>
            <td><a class="btn btn-info" href="game.php?id={$tg->id}">More...</a></td>
        </tr>
ROW;
    }
            
    $ttable = <<<TABLE
    <div class="row">
        <h2 style="margin-top: 0px;">Ranking</h2>
        <p>Ranking of <a href="console.php">Nintendo Switch</a> Games</p>
        <div id="squad-table">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th id="sort-sqno">Our Score</th>
                        <th id="sort-name">Name</th>
                        <th id="sort-nat">Developer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {$trowdata}
                </tbody>
            </table>
        </div>
    </div>
TABLE;
    return $ttable;
}

function renderGameSummary(BLLGame $pg)
{
    $timgref = "img/game/{$pg->id}.png";
    $timg = $timgref;
    $buttontype = "warning";
    if ($pg->score>7) {
        $buttontype = "success";
    } else if ($pg->score<4) {
        $buttontype = "danger";
    }
    $tsummary = <<<SUMMARY
    <div class="col-lg-4">
        <h2>{$pg->gamename}</h2>
        <h3><span class="label label-{$buttontype}">Score: {$pg->score}</span></h3>
        <a href="game.php?id={$pg->id}"><img src={$timg} class="img-responsive" width="360"></a>
        <br><a href="game.php?id={$pg->id}" class="btn btn-info">Find out more...</a>
    </div>
SUMMARY;
    return $tsummary;
}

function renderGameReview(BLLReview $pr)
{
    $tgamereview = $pr->review;
    $treview = <<<REVIEW
    <div class="row" style="margin-bottom:-10px">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Our Game Review</h3>
            </div>
            <div class="panel-body">
                <p>{$tgamereview}</p>
            </div>
        </div>
    </div>
REVIEW;
    return $treview;
}

function renderExternalReviews($pexternalreviews, $pid)
{
    $textreview = "";
    
    foreach($pexternalreviews as $pe)
    {
        if ($pe->refid == $pid ) {
            
            $buttontype = "warning";
            if ($pe->score>7) {
                $buttontype = "success";
            } else if ($pe->score<4) {
                $buttontype = "danger";
            }
            
            $textreview .= <<<REVIEW
            <div class="col-sm-4">
                <div class="card" style="">
                    <div class="card-body">
                        <h3 class="card-title"><b>{$pe->reviewer}</b></h3>
                        <p class="card-text"></p>
                        <a class="btn btn-{$buttontype}"><b>Score: {$pe->score}</b></a>    <a href="{$pe->link}" class="btn btn-primary">See full review</a>
                    </div>
                </div>
            </div>
REVIEW;
        }
    }
    
    $treviews = <<<EXTERNALREVIEWS
    <div class="row">
        <h2>External Reviews</h2>
        {$textreview}
    </div>

EXTERNALREVIEWS;
    
    return $treviews;
}

function renderRetailers($pretailers, $pid)
{
    $tretailers = $pretailers;
    $tretailercards = "";
    
    foreach($tretailers as $pr)
    {
        if ($pr->refid == $pid ) {
            $tretailercards .= <<<RETAILERCARDS
            <div class="col-sm-4">
                <div class="well">
                    <h2>{$pr->retailer}</h2>
                    <h3>Price: £{$pr->price}</h3>
                    <a class="btn btn-primary pull-right" href="{$pr->link}">Go to Retailer</a>
                </div>
            </div>
RETAILERCARDS;
        }
    }
    
    $tallretailers = <<<RETAILERS
    <div class="row">
        <h2>Get the game from:</h2>
        {$tretailercards}
    </div>
    
RETAILERS;
        return $tallretailers;
}

function renderCarousel(array $pimgs,$pimgdir)
{
    $tci = "";
    $count = 0;
    
    //-------Build the Images---------------------------------------------------------
    foreach($pimgs as $titem)
    {
        $tactive = $count === 0 ? " active": "";
        $thtml = <<<ITEM
        <div class="item{$tactive}">
            <img class="img-responsive" src="{$pimgdir}/carousel/{$titem->imgref}">
            <div class="container">
                <div class="carousel-caption">
                    <h1>{$titem->title}</h1>
                    <p class="lead">{$titem->lead}</p>
		        </div>
			</div>
	    </div>            
ITEM;
        $tci .=$thtml;
        $count++;
    }
    
    //--Build Navigation-------------------------
    $tdot = "";  $tdotset = ""; $tarrows = "";
  
    if($count > 1)
    {
        for($i=0; $i < count($pimgs);$i++)
        {
            if($i === 0)
               $tdot .= "<li data-target=\"#myCarousel\" data-slide-to=\"$i\" class=\"active\"></li>";
            else
               $tdot .= "<li data-target=\"#myCarousel\" data-slide-to=\"$i\"></li>";
        }       
        $tdotset = <<<INDICATOR
        <ol class="carousel-indicators">
        {$tdot}
        </ol>
INDICATOR;
     }
     if($count > 1)
     {
        $tarrows = <<<ARROWS
		<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
ARROWS;
     }    
        
    $tcarousel = <<<CAROUSEL
    <div class="carousel slide" id="myCarousel">
            {$tdotset}
			<div class="carousel-inner">
				{$tci}
			</div>	
		    {$tarrows}
    </div>
CAROUSEL;
    return $tcarousel;
}

function renderKeyInformation(BLLConsole $pc) {
    
    $tkeyinformation = <<<KEYINFORMATION
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Key Information</h2>
        </div>
        <div class="panel-body">
            <p>{$pc->description}</p>
            <p><b>Release date:</b> {$pc->releasedate}</p>
            <p><b>Price:</b> {$pc->price}</p>
            <a class="btn btn-info" href="{$pc->retailer}">Buy a Nintendo Switch</a>
        </div>
    </div>
KEYINFORMATION;
    
    return $tkeyinformation;
}

function renderQuote() {
    $tquote = <<<QUOTE
    <div class="carousel slide" id="myCarousel">
        <div class="carousel-inner">
            <div class="item active">
                <img class="img-responsive" src="img/carousel/review.png">
            </div>            
        </div>			    
    </div>
    <blockquote>
        Nintendo Switch now settled into its lifespan, joined by the Nintendo Switch Lite, 
        and granted access to a wide selection of awesome games (and even more great games on the way in 2020), 
        now could be the perfect time for those interested in the Switch to pick one up if they haven't already...
        <small>T3 in <cite title="Nintendo Switch review"><a href="https://www.t3.com/reviews/nintendo-switch-review">Nintendo Switch Review</a></cite></small>
    </blockquote>
QUOTE;
    return $tquote;
}

function renderVideo() {
    $tvideo = <<<VIDEO
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/K0D2xAI2TqA" frameborder="0" allowfullscreen></iframe>
    </div>
VIDEO;
    return $tvideo;
}
    
function renderReview() {
    $treview = <<<REVIEW
        <div class="row">
        <h2>In-depth Review</h2>
        <div class="well">
            <h4><a href="https://www.tomsguide.com/uk/author/richard-priday">Richard Priday</a> in Tom's Guide - February 26, 2020</h4>
            <p>The much-beloved Nintendo Switch, a cross between a handheld and traditional game console, helped Nintendo turn things around after the lackluster Wii U. Since the Switch's launch in March 2017, we've seen the console get a revised version with improved battery life and a new Switch Lite model designed solely for handheld use. In light of these changes, it's high time to revisit our Nintendo Switch review, and reassess the platform's quality as the console enters its third year. Be sure to also check out our list of the best Nintendo Switch games, which will help steer you toward the system's best titles.</p> <a class="btn btn-primary" href="https://www.tomsguide.com/uk/reviews/nintendo-switch">Read More</a>
        </div>
    </article>
REVIEW;
    return $treview;
}

function renderUserReviews($previews, $pid)
{
    $treviews = $previews;
    $treviewpanels = "";
    
    foreach($treviews as $pr)
    {
        if ($pr->refid == $pid ) {
            $tstars = "";
            for ($i = 0; $i < $pr->rating; $i++) {
                $tstars .= '<img src="img\stars\star.png" width="13">';
            }
            $temptystars = 5;
            for ($i = 0; $i < ($temptystars - $pr->rating); $i++) {
                $tstars .= '<img src="img\stars\star-light.png" width="13">';
            }
            $treviewpanels .= <<<REVIEWPANELS
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"> {$tstars} {$pr->email} </h4>
                </div>
                <div class="panel-body">
                    <p>{$pr->review}</p>
                </div>
            </div>
REVIEWPANELS;
        }
    }
    
    if (!$treviewpanels ?? "") {
        $treviewpanels ='
                <h4 class="panel-heading">This game has no user reviews.</h4>
                <p>Be first to add a review</p>
        ';
    }
    
    $taddreview = <<<BUTTON
    <a class="btn btn-primary" href="review.php?refid={$pid}">Add a Review</a>
BUTTON;
    $tlogin = '<a class="btn btn-danger">You need to be logged-in to add a review!</a>';
    
    $tauth = isset($_SESSION["myuser"]) ? $taddreview : $tlogin;
    
    $tallreviews = <<<REVIEWS
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">User Reviews</h3>
                </div>
                <div class="panel-body">
                    {$treviewpanels}
                    {$tauth}
                </div>
            </div>
        </div>
REVIEWS;
                    
        return $tallreviews;
}

function renderOptions($tgames, $trefid) {
    $toptions = "";
    foreach($tgames as $pg)
    {
        if ($pg->id == $trefid) {
            $toptions .= <<<OPTIONS
            <option value="{$pg->id}" selected>{$pg->id} - {$pg->gamename}</option>
OPTIONS;
        } else {
            $toptions .= <<<OPTIONS
            <option value="{$pg->id}">{$pg->id} - {$pg->gamename}</option>
OPTIONS;
        }
    }
    return $toptions;
}

function renderNintendoKeyInformation() {
    $tkeyinformation = <<<KEYINFORMATION
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nintendo Key Information</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">23 September 1889</span>
                        Founded
                    </li>
                    <li class="list-group-item">
                    <span class="badge">Fusajiro Yamauchi</span>
                        Founder
                    </li>
                    <li class="list-group-item">
                        <span class="badge">¥1.201 trillion</span>
                        Revenue
                    </li>
                    <li class="list-group-item">
                    <span class="badge">Kyoto, Japan</span>
                        Headquarters
                    </li>
                    <li class="list-group-item">
                    <span class="badge">6,113</span>
                        Number of employees
                    </li>
                </ul>
            </div>
        </div>
    </div>
KEYINFORMATION;
    return $tkeyinformation;
}

function renderNintendoTabs() {
    $ttabs = <<<TABS
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#history" data-toggle="tab" aria-expanded="true">Nintendo</a>
            </li>
            <li class="">
                <a href="#localisation" data-toggle="tab" aria-expanded="false">Localisation</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <article class="tab-pane fade active in" id="history">
                <section class="well">
                    <h4>Article on Nintendo from <a href="https://en.wikipedia.org/">Wikipedia</a></h4>
                    <p>Nintendo Co., Ltd. is a Japanese multinational consumer electronics and video game company headquartered in Kyoto. Its international branches, Nintendo of America and Nintendo of Europe, are respectively headquartered in Redmond, Washington, and Frankfurt, Germany. Nintendo is one of the world's largest video game companies by market capitalization, creating some of the best-known and top-selling video game franchises of all-time, such as Mario, The Legend of Zelda, Animal Crossing, and Pokémon.
                    <p>Nintendo was founded by Fusajiro Yamauchi on 23 September 1889 and originally produced handmade hanafuda playing cards. By 1963, the company had tried several small niche businesses, such as cab services and love hotels, without major success. Abandoning previous ventures in favor of toys in the 1960s, Nintendo developed into a video game company in the 1970s. Supplemented since the 1980s by its regional branches Nintendo of America and Nintendo of Europe, it ultimately became one of the most influential in the video game industry and one of Japan's most-valuable companies, with a market value of over US$37 billion by 2018.</p>
                    <a class="btn btn-info" href="https://en.wikipedia.org/wiki/Nintendo">Read More...</a>
                </section>
            </article>
            <article class="tab-pane fade" id="localisation">
                <iframe class="maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3271.566168018672!2d135.78142331553636!3d34.91733517909197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60010f59fb28a1c5%3A0xb2a32575ed6d0b8!2sNintendo%20Headquarters!5e0!3m2!1sen!2suk!4v1588602140673!5m2!1sen!2suk" width="100%" height="600" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </article>
        </div>
    </div>
TABS;
    return $ttabs;
}

?>