<?php

class Teachers_pdf extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('site/teachers_model');
		$this->load->model('site/teacherspdf_model');
		$this->load->model('site/section_model');
		$data['site_name'] = $this->config->item( 'site_name' );
		$this->load->vars( $data );
		$this->logged_in_admin();
	}


	/*************************************************************************************/
	// FUNCTION NAME :: logged_in_admin()
	// Checks to see if student user is currently logged in
	// If not - send them to the login page again
	/*************************************************************************************/
	function logged_in_admin()
	{
		$logged_in_admin = $this->session->userdata('logged_in_admin');	
		if( ! isset( $logged_in_admin ) || $logged_in_admin != true )
		{
			redirect('main/login_admin', 'refresh');
		}
	}


	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR CREATING THE 'REAL TIME' PDF REPORT (FPDF)
	/*************************************************************************************************************************************************************************/
	
	/**************************************************************/
	// PAGE HEADER
	/**************************************************************/
	function pageHeader() {
		
		$this->fpdf->AddFont('DINReg','','DIN-Regular.php');
		$this->fpdf->AddFont('DINMed','','DIN-Medium.php');
		
	}
	
	
	
	/**************************************************************/
	// START MAIN PDF OUTPUT HERE!!!
	/**************************************************************/
	function results_PDF() {


		$this->form_validation->set_rules('token', 'token', 'trim|required');
		//$this->form_validation->set_rules('classID', 'Select Class', 'trim|required');
		//$this->form_validation->set_rules('topic', 'Select Topic', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
		
			// SET SOME GLOBAL CONFIG SETTINGS FOR THE PDF
			$this->load->library('fpdf');
			$this->fpdf->FPDF( 'P', 'mm', 'A4'); //set document to portrait, mm and A4
			define('FPDF_FONTPATH', $this->config->item('fonts_path')); //set master fonts path
			
			$this->fpdf->Open();
			//$this->fpdf->AddPage();
			
			//$this->fpdf->Image('images/PDF_Header.jpg', 0, 0, 210, 297);
			$this->fpdf->SetDisplayMode('fullpage', 'continuous'); // Opens PDF in 'full page mode'
			$this->fpdf->SetMargins(5, 5, 5); //set page marging to 10mm (top, left and right)
			$this->fpdf->SetAutoPageBreak('auto', 5);
			
			$this->pageHeader(); //print header
			
			
			// Initiate these vars so they don't return 'empty' errors
			$data = array();
			$topic = array();
			$results = array();



			/*******************************************************************************************************/
			// QUERY RESULTS TO FEED INTO REPORT
			/*******************************************************************************************************/
			if($query = $this->teacherspdf_model->getclass_results())
			{
				$students = $query;
			}

			// Gets the Class Name to display at the head of the report
			if($query = $this->teacherspdf_model->get_class_name())
			{
				$class = $query;
			}

			// Gets the Class Name to display at the head of the report
			if($query = $this->teacherspdf_model->show_topics())
			{
				$topics = $query;
			}

			// Get topic name label from section_helper.php
			$topic = topic_label();



			
			
					
			/*******************************************************************************************************/
			// SET UP PDF RESULTS BLOCK FOR 'INDIVIDUAL' BASED EVENTS
			/*******************************************************************************************************/
			if(isset($students)) 
			{
				
				$setStudentID = FALSE;

				foreach($students as $row): 

					if($setStudentID != $row->studentID) // Create a new page for EVERY student!!!
					{
						
						/**************************************************/
						// Add new page + header logo
						/**************************************************/
						$this->fpdf->AddPage();

						$this->fpdf->Image('images/PDF_Header.jpg', 0, 0, 210, 297); // Add header (logo) to each page
						$this->fpdf->Ln(5); // Add space underneath logo


						/**************************************************/
						// Set colour / font parameters + name of class
						/**************************************************/
						$this->fpdf->SetFont('DINMed', '', 12);
						$this->fpdf->SetTextColor(255, 255, 255);
						$this->fpdf->SetFillColor(100, 100, 100);
						
						$this->fpdf->Ln(10);
						$this->fpdf->Cell(200, 6, 'RESULTS FOR: (' . $class->class_name . ') - ' .  date('Y'), 0, 1, 'B', TRUE); // Add header (Who's it is)


						/**************************************************/
						// Add scoring explanation text
						/**************************************************/
						$this->fpdf->SetFont('DINMed', '', 8);
						$this->fpdf->SetTextColor(0, 0, 0);
						$this->fpdf->Ln(5);
						$this->fpdf->Write(3.5, 'RESULTS EXAMPLE: (11-75%) = 11 tests completed with a 75% average (for the last 5 tests completed).');
						$this->fpdf->Ln(5);

						$this->fpdf->SetFillColor(255, 245, 243);
						$this->fpdf->SetTextColor(0, 0, 0);
						$this->fpdf->SetDrawColor(255, 194, 179);
						$this->fpdf->SetLineWidth(.1);


						/**************************************************/
						// Add labels the will head up each month column
						/**************************************************/
						$this->fpdf->Cell(56, 6, 'STUDENT / TOPIC', 'LRTB', 0, 'L', 1); //Name
						$this->fpdf->Cell(12, 6, 'JAN', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'FEB', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'MAR', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'APR', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'MAY', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'JUN', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'JUL', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'AUG', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'SEP', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'OCT', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'NOV', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Cell(12, 6, 'DEC', 'LRTB', 0, 'C', 1); //Name
						$this->fpdf->Ln();

					}



					/**************************************************/
					// Used to work out the best month score!
					/**************************************************/
					$res = array($row->Jan, $row->Feb, $row->Mar, $row->Apr, $row->May, $row->Jun, $row->Jul, $row->Aug, $row->Sep, $row->Oct, $row->Nov, $row->Dec);
					
					//Max array gets the highest value from above array
					$top = max($res) / 5 * 5;

					

					/*********************************************************************************************/
					// WORK OUT THE VALUES i.e. HOW MANY TEST AND PERCENTAGE SCORE example (7-75%)
					/*********************************************************************************************/
					$Jan = $row->n_Jan . '-' . ($row->Jan / 5) * 10 . '%';
					$Feb = $row->n_Feb . '-' . ($row->Feb / 5) * 10 . '%';
					$Mar = $row->n_Mar . '-' . ($row->Mar / 5) * 10 . '%';
					$Apr = $row->n_Apr . '-' . ($row->Apr / 5) * 10 . '%';
					$May = $row->n_May . '-' . ($row->May / 5) * 10 . '%';
					$Jun = $row->n_Jun . '-' . ($row->Jun / 5) * 10 . '%';
					$Jul = $row->n_Jul . '-' . ($row->Jul / 5) * 10 . '%';
					$Aug = $row->n_Aug . '-' . ($row->Aug / 5) * 10 . '%';
					$Sep = $row->n_Sep . '-' . ($row->Sep / 5) * 10 . '%';
					$Oct = $row->n_Oct . '-' . ($row->Oct / 5) * 10 . '%';
					$Nov = $row->n_Nov . '-' . ($row->Nov / 5) * 10 . '%';
					$Dec = $row->n_Dec . '-' . ($row->Dec / 5) * 10 . '%';


					if($setStudentID != $row->studentID) // Don't repeat student name!!
					{
						$this->fpdf->SetFont('DINMed', '', 8);
						$this->fpdf->SetFillColor(240, 240, 240);
						$this->fpdf->SetLineWidth(.1);

						$this->fpdf->Cell(200, 6, strtoupper($row->last_name) . ', ' . ucwords($row->first_name), 'LRTB', 0, 'L', 1); //Name
						$this->fpdf->Ln();	
					}

					$this->fpdf->SetFont('DINReg', '', 7.6);
					$this->fpdf->SetFillColor(250, 250, 250);
					$this->fpdf->SetDrawColor(220, 220, 220);
					$this->fpdf->SetTextColor(0, 0, 0);
					
					$this->fpdf->Cell(56, 6, $row->topic, 'LRTB', 0, 'L', 1); //Name


					/*************************************************************************************************************/
					// START DISPLAYING THE CELLS WITH NO. TESTS AND % SCORE - and colour code RED the best score!
					/*************************************************************************************************************/
					if($top == $row->Jan) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Jan, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Feb) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Feb, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Mar) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Mar, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Apr) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Apr, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->May) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $May, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Jun) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Jun, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Jul) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Jul, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Aug) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Aug, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Sep) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Sep, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Oct) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Oct, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Nov) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Nov, 'LRTB', 0, 'C', 1); //Name

					if($top == $row->Dec) { $this->fpdf->SetTextColor(255, 51, 0); } else { $this->fpdf->SetTextColor(0, 0, 0); }
					$this->fpdf->Cell(12, 6, $Dec, 'LRTB', 0, 'C', 1); //Name

					$this->fpdf->Ln();


					$setStudentID = $row->studentID;


				endforeach;



			}

			
			
			// Output the file and name it the topic name (i.e. busines_growth.pdf)
			// 'I' means output pdf as continuous page .. 
			// 'D' means output pdf as single page .. 
			$this->fpdf->Output('Results for ' . $class->class_name.'.pdf', 'D'); 


		} //END FORM VALIDATION!
		else
		{
			// If no results - display as error message
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/print_month';
			$this->load->view('site/includes/template', $data);
		}
		
		
	} //END results_PDF()

	

} // END Teachers_pdf class