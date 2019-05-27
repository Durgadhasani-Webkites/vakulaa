<?php
Class Contact_Us_M extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $date = date("Y-m-d H:i:s");
        $ip_address = $this->input->ip_address();
        $this->db->set('user_category', $data['user_category']);
        $this->db->set('user_name', $data['user_name']);
        $this->db->set('user_mobile', $data['user_mobile']);
        $this->db->set('user_email', $data['user_email']);
        $this->db->set('user_message', $data['user_message']);
        if (!empty($data['user_file'])) {
            $this->db->set('user_file', $data['user_file']);
        }
        $this->db->set('ip_address', $ip_address);
        $this->db->set('created', $date);
        $this->db->set('status', 1);
        $this->db->insert('user_enquires');
        if ($this->db->insert_id()) {
            $this->load->library('My_PHPMailer');
            $this->load->config('email');
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = $this->config->item('smtp_host');
            $mail->SMTPAuth = true;
            $mail->Username = $this->config->item('smtp_user');
            $mail->Password = $this->config->item('smtp_pass');
            $mail->Port = $this->config->item('smtp_port');
            $mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));
            $mail->Subject = 'New Enquiry';
            $message = '<p>Dear admin,</p><p>New enquiry has been sent from vakullaa.com. Following are the details of the user:<br/><br/>    Category: ' . $data['user_category'] . '<br/>    Name: ' . $data['user_name'] . '<br/>    Email: ' . $data['user_email'] . '<br/>    Mobile No: ' . $data['user_mobile'] . '<br/>    Message: ' . $data['user_message'] . '<br/><br/></p>';
            $mail->Body = $message;
            $mail->AddAddress($this->config->item('team_email1'));
            $mail->AddAddress($this->config->item('team_email2'));
            if (!empty($data['user_file'])) {
                $mail->addAttachment(FCPATH . 'images/upload/files/' . $data['user_file']);
            }
            $mail->isHTML(true);
            if ($mail->Send()) {
                $this->session->set_flashdata('success', 'Thanks for your message. We will get back to you shortly.');
            } else {
                $this->session->set_flashdata('error', 'Sorry,unable to process to your request. Try again later.');
            }
        }
    }
}