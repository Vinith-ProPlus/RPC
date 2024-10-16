@extends('layouts.admin')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Vendor Master</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center">
					<div class="row">
						<div class="col-12 col-sm-4">	</div>
						<div class="col-12 col-sm-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-12 col-sm-4 my-2 text-right">
							@if($crud['restore']==1)
								<a href="{{ url('/') }}/admin/master/vendor/manage-vendors/trash" class="btn  btn-outline-dark {{$Theme['button-size']}} mr-10" type="button" > Trash </a>
							@endif
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/master/vendor/manage-vendors/create" class="btn  btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Create</a> <!-- full-right -->
							@endif
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12 table-responsive" id="Vendors">
						</div>
					</div>
				</div>
				{{-- <div class="card-body " >
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<table class="table {{$Theme['table-size']}}" id="tblVendors">
								<thead>
									<tr>
										<th>Company Name</th>
										<th>Vendor Name</th>
										<th>Mobile Number</th>
										<th>Vendor Type</th>
										<th>District</th>
										<th class="text-center">No.of.Stockpoints</th>
									</tr>
								</thead>
								<tbody><tr><td class="sorting_1">Abbey Bingham</td><td>Production Painter</td><td>Bellevue</td><td class="dt-type-numeric">3471</td><td>11/15/2006</td><td class="dt-type-numeric">$169,380</td></tr><tr><td class="sorting_1">Abbey Jobson</td><td>Machine Operator</td><td>Amarillo</td><td class="dt-type-numeric">6192</td><td>3/28/2018</td><td class="dt-type-numeric">$24,433</td></tr><tr><td class="sorting_1">Abbey Nicholls</td><td>Paramedic</td><td>Springfield</td><td class="dt-type-numeric">4022</td><td>6/13/2001</td><td class="dt-type-numeric">$27,220</td></tr><tr><td class="sorting_1">Abbey Pearce</td><td>Doctor</td><td>Omaha</td><td class="dt-type-numeric">6070</td><td>4/20/2019</td><td class="dt-type-numeric">$40,609</td></tr><tr><td class="sorting_1">Abbey Shelton</td><td>Retail Trainee</td><td>Lancaster</td><td class="dt-type-numeric">2501</td><td>9/6/2011</td><td class="dt-type-numeric">$116,924</td></tr><tr><td class="sorting_1">Abbey Skinner</td><td>Laboratory Technician</td><td>Stockton</td><td class="dt-type-numeric">6641</td><td>12/20/2012</td><td class="dt-type-numeric">$213,287</td></tr><tr><td class="sorting_1">Abdul Baker</td><td>Global Logistics Supervisor</td><td>Venice</td><td class="dt-type-numeric">8889</td><td>7/8/2000</td><td class="dt-type-numeric">$44,998</td></tr><tr><td class="sorting_1">Abdul Baldwin</td><td>Banker</td><td>Jersey City</td><td class="dt-type-numeric">3785</td><td>2/22/2016</td><td class="dt-type-numeric">$101,457</td></tr><tr><td class="sorting_1">Abdul Bingham</td><td>Audiologist</td><td>Milwaukee</td><td class="dt-type-numeric">4516</td><td>8/6/2018</td><td class="dt-type-numeric">$237,592</td></tr><tr><td class="sorting_1">Abdul Blythe</td><td>Machine Operator</td><td>Prague</td><td class="dt-type-numeric">2128</td><td>9/26/2008</td><td class="dt-type-numeric">$256,882</td></tr><tr><td class="sorting_1">Abdul Chapman</td><td>Budget Analyst</td><td>London</td><td class="dt-type-numeric">4126</td><td>7/1/2017</td><td class="dt-type-numeric">$224,460</td></tr><tr><td class="sorting_1">Abdul Clark</td><td>Health Educator</td><td>Huntsville</td><td class="dt-type-numeric">2957</td><td>9/12/2006</td><td class="dt-type-numeric">$293,015</td></tr><tr><td class="sorting_1">Abdul Exton</td><td>IT Support Staff</td><td>Hollywood</td><td class="dt-type-numeric">1646</td><td>5/25/2011</td><td class="dt-type-numeric">$117,169</td></tr><tr><td class="sorting_1">Abdul Flett</td><td>Project Manager</td><td>Pittsburgh</td><td class="dt-type-numeric">4359</td><td>1/23/2016</td><td class="dt-type-numeric">$100,397</td></tr><tr><td class="sorting_1">Abdul Hope</td><td>Dentist</td><td>Fullerton</td><td class="dt-type-numeric">1546</td><td>8/30/2018</td><td class="dt-type-numeric">$36,290</td></tr><tr><td class="sorting_1">Abdul Hunt</td><td>Webmaster</td><td>Venice</td><td class="dt-type-numeric">1842</td><td>12/13/2018</td><td class="dt-type-numeric">$255,033</td></tr><tr><td class="sorting_1">Abdul Jennson</td><td>Physician</td><td>Milano</td><td class="dt-type-numeric">6948</td><td>1/20/2014</td><td class="dt-type-numeric">$221,477</td></tr><tr><td class="sorting_1">Abdul Jobson</td><td>Project Manager</td><td>Laredo</td><td class="dt-type-numeric">2497</td><td>10/3/2005</td><td class="dt-type-numeric">$68,632</td></tr><tr><td class="sorting_1">Abdul Long</td><td>Bookkeeper</td><td>Orlando</td><td class="dt-type-numeric">6024</td><td>5/30/2006</td><td class="dt-type-numeric">$285,738</td></tr><tr><td class="sorting_1">Abdul Lowe</td><td>Front Desk Coordinator</td><td>Springfield</td><td class="dt-type-numeric">9094</td><td>6/10/2007</td><td class="dt-type-numeric">$54,079</td></tr><tr><td class="sorting_1">Abdul Lucas</td><td>Lecturer</td><td>Fayetteville</td><td class="dt-type-numeric">9859</td><td>6/23/2012</td><td class="dt-type-numeric">$112,439</td></tr><tr><td class="sorting_1">Abdul Lynch</td><td>Baker</td><td>Amarillo</td><td class="dt-type-numeric">3210</td><td>6/8/2008</td><td class="dt-type-numeric">$286,173</td></tr><tr><td class="sorting_1">Abdul Mann</td><td>Paramedic</td><td>St. Louis</td><td class="dt-type-numeric">4263</td><td>12/27/2008</td><td class="dt-type-numeric">$188,055</td></tr><tr><td class="sorting_1">Abdul Moss</td><td>Accountant</td><td>Lincoln</td><td class="dt-type-numeric">6765</td><td>6/18/2008</td><td class="dt-type-numeric">$113,357</td></tr><tr><td class="sorting_1">Abdul Owens</td><td>Global Logistics Supervisor</td><td>Otawa</td><td class="dt-type-numeric">4880</td><td>1/14/2016</td><td class="dt-type-numeric">$93,262</td></tr><tr><td class="sorting_1">Abdul Phillips</td><td>Clerk</td><td>Louisville</td><td class="dt-type-numeric">5670</td><td>3/19/2001</td><td class="dt-type-numeric">$31,520</td></tr><tr><td class="sorting_1">Abdul Ranks</td><td>Service Supervisor</td><td>San Bernardino</td><td class="dt-type-numeric">3996</td><td>4/15/2012</td><td class="dt-type-numeric">$275,356</td></tr><tr><td class="sorting_1">Abdul Reese</td><td>Doctor</td><td>Orlando</td><td class="dt-type-numeric">7439</td><td>3/31/2010</td><td class="dt-type-numeric">$274,622</td></tr><tr><td class="sorting_1">Abdul Reid</td><td>Stockbroker</td><td>Bridgeport</td><td class="dt-type-numeric">5056</td><td>5/10/2014</td><td class="dt-type-numeric">$33,166</td></tr><tr><td class="sorting_1">Abdul Richards</td><td>Call Center Representative</td><td>Norfolk</td><td class="dt-type-numeric">1040</td><td>6/14/2015</td><td class="dt-type-numeric">$291,865</td></tr><tr><td class="sorting_1">Abdul Rixon</td><td>Call Center Representative</td><td>Fullerton</td><td class="dt-type-numeric">2387</td><td>8/11/2008</td><td class="dt-type-numeric">$154,845</td></tr><tr><td class="sorting_1">Abdul Robertson</td><td>Loan Officer</td><td>Tokyo</td><td class="dt-type-numeric">4499</td><td>6/6/2014</td><td class="dt-type-numeric">$249,163</td></tr><tr><td class="sorting_1">Abdul Russell</td><td>Machine Operator</td><td>Oklahoma City</td><td class="dt-type-numeric">3453</td><td>10/4/2010</td><td class="dt-type-numeric">$102,181</td></tr><tr><td class="sorting_1">Abdul Simpson</td><td>Mobile Developer</td><td>San Francisco</td><td class="dt-type-numeric">5204</td><td>12/18/2010</td><td class="dt-type-numeric">$66,510</td></tr><tr><td class="sorting_1">Abdul Umney</td><td>IT Support Staff</td><td>Bakersfield</td><td class="dt-type-numeric">6873</td><td>11/1/2016</td><td class="dt-type-numeric">$209,663</td></tr><tr><td class="sorting_1">Abdul Vince</td><td>Design Engineer</td><td>Norfolk</td><td class="dt-type-numeric">1358</td><td>10/17/2007</td><td class="dt-type-numeric">$165,279</td></tr><tr><td class="sorting_1">Abdul Whinter</td><td>Retail Trainee</td><td>Omaha</td><td class="dt-type-numeric">4565</td><td>11/25/2005</td><td class="dt-type-numeric">$111,368</td></tr><tr><td class="sorting_1">Abdul Wilkinson</td><td>Front Desk Coordinator</td><td>Prague</td><td class="dt-type-numeric">6701</td><td>2/21/2011</td><td class="dt-type-numeric">$283,187</td></tr><tr><td class="sorting_1">Abdul Wright</td><td>Cook</td><td>Cincinnati</td><td class="dt-type-numeric">4694</td><td>8/24/2012</td><td class="dt-type-numeric">$137,155</td></tr><tr><td class="sorting_1">Abdul Yarwood</td><td>Health Educator</td><td>Bellevue</td><td class="dt-type-numeric">1867</td><td>9/27/2014</td><td class="dt-type-numeric">$112,782</td></tr><tr><td class="sorting_1">Ada Dwyer</td><td>Insurance Broker</td><td>Bellevue</td><td class="dt-type-numeric">2961</td><td>12/19/2016</td><td class="dt-type-numeric">$298,419</td></tr><tr><td class="sorting_1">Ada Judd</td><td>CNC Operator</td><td>Las Vegas</td><td class="dt-type-numeric">3641</td><td>1/27/2016</td><td class="dt-type-numeric">$186,194</td></tr><tr><td class="sorting_1">Ada Ogilvy</td><td>Global Logistics Supervisor</td><td>Saint Paul</td><td class="dt-type-numeric">5289</td><td>4/16/2002</td><td class="dt-type-numeric">$132,327</td></tr><tr><td class="sorting_1">Ada Warner</td><td>Audiologist</td><td>Boston</td><td class="dt-type-numeric">9109</td><td>7/11/2008</td><td class="dt-type-numeric">$35,463</td></tr><tr><td class="sorting_1">Adalie Anderson</td><td>Associate Professor</td><td>Fort Lauderdale</td><td class="dt-type-numeric">7989</td><td>12/24/2011</td><td class="dt-type-numeric">$270,714</td></tr><tr><td class="sorting_1">Adalie Hamilton</td><td>Cash Manager</td><td>Milano</td><td class="dt-type-numeric">1137</td><td>3/23/2008</td><td class="dt-type-numeric">$240,099</td></tr><tr><td class="sorting_1">Adalie Hobson</td><td>Dentist</td><td>Huntsville</td><td class="dt-type-numeric">1318</td><td>7/20/2009</td><td class="dt-type-numeric">$183,751</td></tr><tr><td class="sorting_1">Adalie Kennedy</td><td>Machine Operator</td><td>Indianapolis</td><td class="dt-type-numeric">6357</td><td>2/18/2008</td><td class="dt-type-numeric">$267,686</td></tr><tr><td class="sorting_1">Adalie Latham</td><td>Treasurer</td><td>Lincoln</td><td class="dt-type-numeric">4418</td><td>10/7/2011</td><td class="dt-type-numeric">$91,938</td></tr><tr><td class="sorting_1">Adalie Little</td><td>Chef Manager</td><td>Innsbruck</td><td class="dt-type-numeric">8142</td><td>5/24/2015</td><td class="dt-type-numeric">$299,475</td></tr><tr><td class="sorting_1">Adalie Norburn</td><td>Food Technologist</td><td>Bellevue</td><td class="dt-type-numeric">3959</td><td>7/30/2018</td><td class="dt-type-numeric">$181,633</td></tr><tr><td class="sorting_1">Adalie Pickard</td><td>HR Coordinator</td><td>Detroit</td><td class="dt-type-numeric">4653</td><td>7/11/2004</td><td class="dt-type-numeric">$54,380</td></tr><tr><td class="sorting_1">Adalie Reynolds</td><td>HR Coordinator</td><td>Sacramento</td><td class="dt-type-numeric">2692</td><td>11/24/2013</td><td class="dt-type-numeric">$49,004</td></tr><tr><td class="sorting_1">Adalind Adler</td><td>Insurance Broker</td><td>Garland</td><td class="dt-type-numeric">9192</td><td>6/19/2016</td><td class="dt-type-numeric">$122,074</td></tr><tr><td class="sorting_1">Adalind Barrett</td><td>Banker</td><td>Phoenix</td><td class="dt-type-numeric">4057</td><td>10/7/2017</td><td class="dt-type-numeric">$283,714</td></tr><tr><td class="sorting_1">Adalind Coll</td><td>Staffing Consultant</td><td>Salt Lake City</td><td class="dt-type-numeric">1847</td><td>12/26/2017</td><td class="dt-type-numeric">$298,429</td></tr><tr><td class="sorting_1">Adalind Ebbs</td><td>HR Specialist</td><td>Scottsdale</td><td class="dt-type-numeric">6788</td><td>3/30/2005</td><td class="dt-type-numeric">$272,919</td></tr><tr><td class="sorting_1">Adalind Edler</td><td>Retail Trainee</td><td>New York</td><td class="dt-type-numeric">4227</td><td>7/11/2019</td><td class="dt-type-numeric">$102,210</td></tr><tr><td class="sorting_1">Adalind Ellison</td><td>Software Engineer</td><td>Murfreesboro</td><td class="dt-type-numeric">3769</td><td>4/7/2010</td><td class="dt-type-numeric">$290,176</td></tr><tr><td class="sorting_1">Adalind Kelly</td><td>Accountant</td><td>Tulsa</td><td class="dt-type-numeric">5821</td><td>3/18/2015</td><td class="dt-type-numeric">$298,767</td></tr><tr><td class="sorting_1">Adalind Osman</td><td>Global Logistics Supervisor</td><td>Honolulu</td><td class="dt-type-numeric">5934</td><td>8/25/2005</td><td class="dt-type-numeric">$123,573</td></tr><tr><td class="sorting_1">Adalind Palmer</td><td>Food Technologist</td><td>El Paso</td><td class="dt-type-numeric">4812</td><td>8/17/2014</td><td class="dt-type-numeric">$213,710</td></tr><tr><td class="sorting_1">Adalind Robinson</td><td>Project Manager</td><td>Hollywood</td><td class="dt-type-numeric">8147</td><td>2/7/2015</td><td class="dt-type-numeric">$139,558</td></tr><tr><td class="sorting_1">Adalind Thornton</td><td>Accountant</td><td>Otawa</td><td class="dt-type-numeric">6806</td><td>4/8/2006</td><td class="dt-type-numeric">$270,746</td></tr><tr><td class="sorting_1">Adela Bryson</td><td>Insurance Broker</td><td>Ontario</td><td class="dt-type-numeric">9479</td><td>7/22/2000</td><td class="dt-type-numeric">$174,893</td></tr><tr><td class="sorting_1">Adela Hall</td><td>Cashier</td><td>Moreno Valley</td><td class="dt-type-numeric">8134</td><td>6/7/2014</td><td class="dt-type-numeric">$147,095</td></tr><tr><td class="sorting_1">Adela Mcleod</td><td>Dentist</td><td>Toledo</td><td class="dt-type-numeric">2201</td><td>3/12/2003</td><td class="dt-type-numeric">$123,617</td></tr><tr><td class="sorting_1">Adela Warden</td><td>Associate Professor</td><td>Milano</td><td class="dt-type-numeric">1635</td><td>3/23/2002</td><td class="dt-type-numeric">$146,627</td></tr><tr><td class="sorting_1">Adelaide Coates</td><td>Web Developer</td><td>Bellevue</td><td class="dt-type-numeric">5262</td><td>12/28/2004</td><td class="dt-type-numeric">$191,714</td></tr><tr><td class="sorting_1">Adelaide Gates</td><td>Paramedic</td><td>Venice</td><td class="dt-type-numeric">5764</td><td>8/9/2017</td><td class="dt-type-numeric">$71,606</td></tr><tr><td class="sorting_1">Adelaide Mitchell</td><td>Healthcare Specialist</td><td>Hayward</td><td class="dt-type-numeric">9352</td><td>6/25/2001</td><td class="dt-type-numeric">$68,538</td></tr><tr><td class="sorting_1">Adelaide Plumb</td><td>Staffing Consultant</td><td>Lancaster</td><td class="dt-type-numeric">5367</td><td>1/24/2001</td><td class="dt-type-numeric">$117,119</td></tr><tr><td class="sorting_1">Adelaide Rainford</td><td>Webmaster</td><td>Detroit</td><td class="dt-type-numeric">2897</td><td>6/21/2001</td><td class="dt-type-numeric">$170,765</td></tr><tr><td class="sorting_1">Adelaide Rose</td><td>Audiologist</td><td>Bucharest</td><td class="dt-type-numeric">4078</td><td>4/22/2001</td><td class="dt-type-numeric">$294,013</td></tr><tr><td class="sorting_1">Adelaide Ross</td><td>Steward</td><td>New York</td><td class="dt-type-numeric">3550</td><td>6/6/2011</td><td class="dt-type-numeric">$157,500</td></tr><tr><td class="sorting_1">Adelaide Weldon</td><td>Laboratory Technician</td><td>Portland</td><td class="dt-type-numeric">8263</td><td>8/8/2017</td><td class="dt-type-numeric">$194,242</td></tr><tr><td class="sorting_1">Adeline Booth</td><td>Restaurant Manager</td><td>Zurich</td><td class="dt-type-numeric">6743</td><td>9/11/2017</td><td class="dt-type-numeric">$186,302</td></tr><tr><td class="sorting_1">Adeline Clarke</td><td>Ambulatory Nurse</td><td>Moreno Valley</td><td class="dt-type-numeric">5373</td><td>1/4/2013</td><td class="dt-type-numeric">$296,713</td></tr><tr><td class="sorting_1">Adeline Cox</td><td>Bellman</td><td>Anaheim</td><td class="dt-type-numeric">1042</td><td>5/25/2014</td><td class="dt-type-numeric">$248,413</td></tr><tr><td class="sorting_1">Adeline Emmett</td><td>Operator</td><td>New Orleans</td><td class="dt-type-numeric">2040</td><td>6/14/2006</td><td class="dt-type-numeric">$158,844</td></tr><tr><td class="sorting_1">Adeline Johnson</td><td>Call Center Representative</td><td>Quebec</td><td class="dt-type-numeric">4937</td><td>10/24/2001</td><td class="dt-type-numeric">$141,397</td></tr><tr><td class="sorting_1">Adeline Jones</td><td>Project Manager</td><td>Los Angeles</td><td class="dt-type-numeric">5261</td><td>3/7/2011</td><td class="dt-type-numeric">$106,499</td></tr><tr><td class="sorting_1">Adeline Mitchell</td><td>HR Coordinator</td><td>Stockton</td><td class="dt-type-numeric">7869</td><td>2/1/2016</td><td class="dt-type-numeric">$23,704</td></tr><tr><td class="sorting_1">Adeline Radley</td><td>Assistant Buyer</td><td>Zurich</td><td class="dt-type-numeric">1896</td><td>12/11/2006</td><td class="dt-type-numeric">$39,799</td></tr><tr><td class="sorting_1">Adeline Riley</td><td>HR Coordinator</td><td>Boston</td><td class="dt-type-numeric">4672</td><td>1/3/2010</td><td class="dt-type-numeric">$262,035</td></tr><tr><td class="sorting_1">Adeline Riley</td><td>Project Manager</td><td>Saint Paul</td><td class="dt-type-numeric">7556</td><td>4/27/2016</td><td class="dt-type-numeric">$169,118</td></tr><tr><td class="sorting_1">Adeline Shepherd</td><td>Operator</td><td>San Jose</td><td class="dt-type-numeric">2756</td><td>6/7/2007</td><td class="dt-type-numeric">$81,244</td></tr><tr><td class="sorting_1">Adeline Thompson</td><td>Health Educator</td><td>Springfield</td><td class="dt-type-numeric">7145</td><td>12/29/2002</td><td class="dt-type-numeric">$259,531</td></tr><tr><td class="sorting_1">Adeline Whinter</td><td>Doctor</td><td>Henderson</td><td class="dt-type-numeric">3930</td><td>9/24/2000</td><td class="dt-type-numeric">$174,839</td></tr><tr><td class="sorting_1">Adina Beal</td><td>Cash Manager</td><td>Detroit</td><td class="dt-type-numeric">5657</td><td>2/4/2001</td><td class="dt-type-numeric">$52,646</td></tr><tr><td class="sorting_1">Adina Holt</td><td>Restaurant Manager</td><td>Venice</td><td class="dt-type-numeric">9293</td><td>1/12/2018</td><td class="dt-type-numeric">$51,127</td></tr><tr><td class="sorting_1">Adina Hope</td><td>Accountant</td><td>Cincinnati</td><td class="dt-type-numeric">2270</td><td>7/28/2012</td><td class="dt-type-numeric">$12,065</td></tr><tr><td class="sorting_1">Adina Matthews</td><td>Bellman</td><td>San Bernardino</td><td class="dt-type-numeric">1541</td><td>2/4/2007</td><td class="dt-type-numeric">$212,437</td></tr><tr><td class="sorting_1">Adina Robe</td><td>Call Center Representative</td><td>Berna</td><td class="dt-type-numeric">4746</td><td>1/8/2018</td><td class="dt-type-numeric">$142,403</td></tr><tr><td class="sorting_1">Aeris Butler</td><td>Food Technologist</td><td>Atlanta</td><td class="dt-type-numeric">3453</td><td>1/20/2007</td><td class="dt-type-numeric">$114,701</td></tr><tr><td class="sorting_1">Aeris Herbert</td><td>Inspector</td><td>Tokyo</td><td class="dt-type-numeric">1520</td><td>2/21/2006</td><td class="dt-type-numeric">$112,230</td></tr><tr><td class="sorting_1">Aeris Lunt</td><td>Paramedic</td><td>Jacksonville</td><td class="dt-type-numeric">8772</td><td>12/3/2006</td><td class="dt-type-numeric">$251,201</td></tr><tr><td class="sorting_1">Aeris Nash</td><td>Treasurer</td><td>Springfield</td><td class="dt-type-numeric">1305</td><td>1/25/2017</td><td class="dt-type-numeric">$234,025</td></tr><tr><td class="sorting_1">Aeris Oliver</td><td>Lecturer</td><td>Houston</td><td class="dt-type-numeric">9581</td><td>7/25/2005</td><td class="dt-type-numeric">$79,660</td></tr><tr><td class="sorting_1">Aeris Preston</td><td>Cook</td><td>San Antonio</td><td class="dt-type-numeric">8795</td><td>1/14/2015</td><td class="dt-type-numeric">$193,178</td></tr></tbody>
							</table>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
		@if($crud['view']==1)
			const Vendors=$('#Vendors').pplDataTable({
                processing: true,
                serverSide: true,
                csrfToken:"{{csrf_token()}}",
                tableConfig:{
                    get:"{{route('admin.get.table.config',[$UInfo->UserID,'vendors'])}}",
                    save:"{{route('admin.save.table.config',[$UInfo->UserID,'vendors'])}}"
                },
                ajax: {
                    url:"{{url('/')}}/admin/master/vendor/manage-vendors/data?_token="+$('meta[name=_token]').attr('content'),
                    headers:{ 'X-CSRF-Token' :"{{csrf_token()}}" } ,
                    type: "POST"
                },
                permissions:JSON.parse('<?php echo json_encode($crud); ?>'),
                tableName:"vendors"
            });
		@endif
		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/admin/master/vendor/manage-vendors/edit/"+ $(this).attr('data-id'));
		});
		$(document).on('click', '.btnVendorInfo', function (e) {
            e.preventDefault();
            let VendorName = $(this).attr('data-vendor-name');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/master/vendor/manage-vendors/get/vendor-info",
                data: { VendorID: $(this).attr('data-id') },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let modalContent = $('<div></div>');
                    let row = $('<div class="row my-3 justify-content-center">').html(`
								<div class="row">
									<div class="col-sm-12 text-center">
										<img loading="lazy" src="{{ url('/') }}/${response.Logo}" alt="Vendor Logo" class="img-fluid rounded" height="150" width="150">
									</div>
									<div class="row mt-20 justify-content-center">
										<div class="col-sm-5">
											<div class="row">
												<div class="col-sm-6 fs-15 fw-600">Vendor Name</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.VendorName}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Email</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.Email}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Address</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.Address}, ${response.CityName}<br>${response.TalukName}, ${response.DistrictName}<br>${response.StateName}-${response.PostalCode}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">GST No</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.GSTNo}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Mobile No</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.MobileNumber1}</div>
											</div>
											${response.StockPoints.length > 0 ?
												`<div class="row my-2">
													<div class="col-sm-6 fs-15 fw-600">Primary Stock Point</div>
													<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
													<div class="col-sm-5 fs-15">${response.StockPoints[0].Address}, ${response.StockPoints[0].CityName}<br>${response.StockPoints[0].TalukName}, ${response.StockPoints[0].DistrictName}<br>${response.StockPoints[0].StateName}-${response.StockPoints[0].PostalCode}.<br><span class></span></div>
												</div>` :
												''
											}
										</div>
									</div>
								</div>`);

                        modalContent.append(row);
						let documentsRow = $('<div class="row my-3 justify-content-center">');
							documentsRow.append(`<div class="col-sm-12 my-2"><h5 class="text-center text-info">Vendor Documents</h5></div>`);

						response.Documents.forEach(function (document) {
							let documentElement;
							documentElement = `<a href="${document.documents}" target="_blank"><img loading="lazy" src="${document.DefaultImage}" alt="${document.DisplayName}" class="img-fluid rounded" height="150" width="150"></a>`;
							documentsRow.append(`
								<div class="col-sm-3 text-center">
									<h6>${document.DisplayName}</h6>
									${documentElement}
								</div>
							`);
						});
						modalContent.append("<hr>");
						modalContent.append(documentsRow);

                    let dialog = bootbox.dialog({
                        title: "Vendor ( " + VendorName + " )",
                        closeButton: true,
                        message: modalContent,
                        className: 'modal-xl',
                    });
                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });
                }
            });
        });
		$(document).on('click','.btnApprove',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Approve this vendor!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Approve it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/vendor/manage-vendors/approve/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		Vendors.ajaxReload();
                    		toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}else{
                    		toastr.error(response.message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}
                    }
            	});
            });
		});
		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Delete this vendor!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/vendor/manage-vendors/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		Vendors.ajaxReload();
                    		toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}else{
                    		toastr.error(response.message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}
                    }
            	});
            });
		});
    });
</script>
@endsection
