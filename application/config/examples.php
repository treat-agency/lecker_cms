 <?


  function index()
    {
        $data = array();
        $data['page_title'] = "Title on Tab";


        /*****   LANDING PAGE INFO   *****/

        $lp_data = $this->fm->getLandingPageData();

        // save whatever you want here
        $data['lp_data'] = $this->fm->getLandingPageData();

        $this->load_view('frontend/home', $data);
    }