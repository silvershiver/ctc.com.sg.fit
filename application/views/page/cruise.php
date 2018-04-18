<!--main-->
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<!--main content-->
			<div class="content clearfix">
				<!--breadcrumbs-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<!--crumbs-->
					<ul class="crumbs">
						<li><?php echo anchor('main/index', 'Home'); ?></li> 
						<li><?php echo anchor('main/cruise', 'Cruise'); ?></li>  
						<li>Search results</li>                                       
					</ul>
					<!--//crumbs-->
					
					<!--top right navigation-->
					<ul class="top-right-nav">
						<li><a href="#" title="Back to results">Back to results</a></li>
						<li><a href="#" title="Change search">Change search</a></li>
					</ul>
					<!--//top right navigation-->
				</nav>
				<!--//breadcrumbs-->
			
				<!--sidebar-->
				<aside class="left-sidebar">
					<article class="refine-search-results">
						<h2>Refine search results</h2>
						<dl>
							<!--Departure times-->
							<dt>Departure times</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch1" name="departure" />
									<label for="ch1">Lowest fare</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch2" name="departure" />
									<label for="ch2">Morning</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch3" name="departure" />
									<label for="ch3">Midday</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch4" name="departure" />
									<label for="ch4">Afternoon</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch5" name="departure" />
									<label for="ch5">Evening</label>
								</div>
							</dd>
							<!--//Departure times-->
							
							<!--Stops-->
							<dt>Stops</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch6" name="stop" />
									<label for="ch6">Direct flights only</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch7" name="stop" />
									<label for="ch7">1 stop</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch8" name="stop" />
									<label for="ch8">2 stops</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch9" name="stop" />
									<label for="ch9">3 stops</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch10" name="stop" />
									<label for="ch10">4 stops</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch11" name="stop" />
									<label for="ch11">I don't mind</label>
								</div>
							</dd>
							<!--//Stops-->

							
							<!--Airlines-->
							<dt>Airlines</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch12" name="airlines" />
									<label for="ch12">British Airways</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch13" name="airlines" />
									<label for="ch13">airberlin</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch14" name="airlines" />
									<label for="ch14">Lufthansa</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch15" name="airlines" />
									<label for="ch15">SAS</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch16" name="airlines" />
									<label for="ch16">Brussels Airlines</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch17" name="airlines" />
									<label for="ch17">Include Low Cost</label>
								</div>
							</dd>
							<!--//Airlines-->
							
							<!--Alliances-->
							<dt>Alliances</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch18" name="alliances" />
									<label for="ch18">One World</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch19" name="alliances" />
									<label for="ch19">Sky Team</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch20" name="alliances" />
									<label for="ch20">Star Alliance </label>
								</div>
							</dd>
							<!--//Alliances-->
							
							<!--Price range-->
							<dt>Price range</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch21" name="price" />
									<label for="ch21">0 - 99 $</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch22" name="price" />
									<label for="ch22">100 - 299 $</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch23" name="price" />
									<label for="ch23">300 - 499 $</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch24" name="price" />
									<label for="ch24">500 - 699 $</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch25" name="price" />
									<label for="ch25">700 $ +</label>
								</div>
							</dd>
							<!--//Price range-->
							
							<!--Class-->
							<dt>Class</dt>
							<dd>
								<div class="checkbox">
									<input type="checkbox" id="ch26" name="class" />
									<label for="ch26">Economy</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch27" name="class" />
									<label for="ch27">Business</label>
								</div>
								<div class="checkbox">
									<input type="checkbox" id="ch28" name="class" />
									<label for="ch28">First</label>
								</div>
							</dd>
							<!--//Class-->
						</dl>
					</article>
				</aside>
				<!--//sidebar-->
			
				<!--three-fourth content-->
					<section class="three-fourth">
						<div class="sort-by">
							<h3>Sort by</h3>
							<ul class="sort">
								<li>Stops <a href="#" title="ascending" class="ascending">ascending</a><a href="#" title="descending" class="descending">descending</a></li>
								<li>Price <a href="#" title="ascending" class="ascending">ascending</a><a href="#" title="descending" class="descending">descending</a></li>
								<li>Duration <a href="#" title="ascending" class="ascending">ascending</a><a href="#" title="descending" class="descending">descending</a></li>
							</ul>
							
							<ul class="view-type">
								<li class="grid-view"><a href="#" title="grid view">grid view</a></li>
								<li class="list-view"><a href="#" title="list view">list view</a></li>
							</ul>
						</div>
						
						<div class="deals clearfix flights">
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--deal-->
							<article class="one-fourth">
								<div class="details">
									<h1>AB 5047 MUC- LHR</h1>
									<div class="f-wrap">
										<h5>Airline</h5>
										<div class="flight-info">Lufthansa</div>
									</div>
									<div class="f-wrap">
										<h5>Departure</h5>
										<div class="flight-info">22:00 Friday, 5 April<br /><strong>Franz Josef Strauss</strong>  (MUC),  Munich  - Germany </div>
									</div>
									<div class="f-wrap">
										<h5>Arrival</h5>
										<div class="flight-info">23:00 Friday, 5 April<br /><strong>Luton International</strong>  (LTN),  London  - United Kingdom </div>
									</div>	
									<div class="f-wrap last">
										<h5>Duration of trip:</h5>
										<div class="flight-info">2 hours 00 minutes </div>
									</div>
									<span class="price">Price per passenger  <em>$ 50</em> </span>
									<div class="description">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
									<a href="booking-step1.html" title="Book now" class="gradient-button">Book now</a>
								</div>
							</article>
							<!--//deal-->
							
							<!--bottom navigation-->
							<div class="bottom-nav">
								<!--back up button-->
								<a href="#" class="scroll-to-top" title="Back up">Back up</a> 
								<!--//back up button-->
								
								<!--pager-->
								<div class="pager">
									<span><a href="#">First page</a></span>
									<span><a href="#">&lt;</a></span>
									<span class="current">1</span>
									<span><a href="#">2</a></span>
									<span><a href="#">3</a></span>
									<span><a href="#">4</a></span>
									<span><a href="#">5</a></span>
									<span><a href="#">6</a></span>
									<span><a href="#">7</a></span>
									<span><a href="#">8</a></span>
									<span><a href="#">&gt;</a></span>
									<span><a href="#">Last page</a></span>
								</div>
								<!--//pager-->
							</div>
							<!--//bottom navigation-->
						</div>
					</section>
				<!--//three-fourth content-->
			</div>
			<!--//main content-->
		</div>
	</div>
	<!--//main-->