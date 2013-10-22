<?
class MY_Controller extends CI_Controller{
    
	public $data = array();

    public function __construct()
    {
        parent::__construct();
        
        // Check for login
        if($this->session->userdata('member_id') == null)
        {
        	redirect('login');
        }

    }
}