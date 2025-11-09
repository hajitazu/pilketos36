<?php

namespace App\Controllers;

use App\Models\TokenModel;
use App\Models\CandidateModel;
use App\Models\VoteModel;
use App\Models\SettingModel;
use CodeIgniter\Controller;

class Voting extends Controller
{
    protected $tokenModel;
    protected $candidateModel;
    protected $voteModel;
    protected $settingModel;
    protected $session;

    public function __construct()
    {
        $this->tokenModel = new TokenModel();
        $this->candidateModel = new CandidateModel();
        $this->voteModel = new VoteModel();
        $this->settingModel = new SettingModel();
        $this->session = session();
    }

    public function index()
    {
        $data['settings'] = $this->settingModel->getAll();
        echo view('layouts/header', $data);
        echo view('voting/index', $data);
        echo view('layouts/footer', $data);
    }

    public function verifyToken()
    {
        $token = $this->request->getPost('token');
        $token = strtoupper(trim($token));

        if (!$this->settingModel->isOpen()) {
            return redirect()->to('/voting')->with('error', 'Pemungutan suara telah ditutup.');
        }

        $t = $this->tokenModel->where('token', $token)->first();
        if (!$t) {
            return redirect()->to('/voting')->with('error', 'Token tidak valid.');
        }
        if ($t['used']) {
            return redirect()->to('/voting')->with('error', 'Token telah digunakan.');
        }

        $this->session->set('voting_token', $token);
        return redirect()->to('/voting/ballot');
    }

    public function ballot()
    {
        $token = $this->session->get('voting_token');
        if (!$token) {
            return redirect()->to('/voting')->with('error', 'Masukkan token terlebih dahulu.');
        }

        if (!$this->settingModel->isOpen()) {
            return redirect()->to('/voting')->with('error', 'Pemungutan suara telah ditutup.');
        }

        $t = $this->tokenModel->where('token', $token)->first();
        if (!$t || $t['used']) {
            $this->session->remove('voting_token');
            return redirect()->to('/voting')->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        $data['candidates'] = $this->candidateModel->findAll();
        $data['settings'] = $this->settingModel->getAll();
        echo view('layouts/header', $data);
        echo view('voting/ballot', $data);
        echo view('layouts/footer', $data);
    }

    public function vote()
    {
        $token = $this->session->get('voting_token');
        if (!$token) {
            return redirect()->to('/voting')->with('error', 'Sesi token hilang. Masukkan token kembali.');
        }

        if (!$this->settingModel->isOpen()) {
            return redirect()->to('/voting')->with('error', 'Pemungutan suara telah ditutup.');
        }

        $candidate_id = (int)$this->request->getPost('candidate_id');
        $t = $this->tokenModel->where('token', $token)->first();
        if (!$t || $t['used']) {
            $this->session->remove('voting_token');
            return redirect()->to('/voting')->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->voteModel->insert([
            'candidate_id' => $candidate_id,
            'token' => $token,
            'voted_at' => date('Y-m-d H:i:s')
        ]);
        $this->tokenModel->update($t['id'], ['used' => 1, 'used_at' => date('Y-m-d H:i:s')]);
        $db->transComplete();

        $this->session->remove('voting_token');

        return redirect()->to('/voting/thanks');
    }

    public function thanks()
    {
        $data['settings'] = $this->settingModel->getAll();
        echo view('layouts/header', $data);
        echo view('voting/thanks', $data);
        echo view('layouts/footer', $data);
    }
}
