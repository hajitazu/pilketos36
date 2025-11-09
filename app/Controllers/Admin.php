<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\SettingModel;
use App\Models\CandidateModel;
use App\Models\VoteModel;
use App\Models\TokenModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $adminModel;
    protected $settingModel;
    protected $candidateModel;
    protected $voteModel;
    protected $tokenModel;
    protected $session;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->settingModel = new SettingModel();
        $this->candidateModel = new CandidateModel();
        $this->voteModel = new VoteModel();
        $this->tokenModel = new TokenModel();
        $this->session = session();
    }

    public function login()
    {
        if ($this->session->get('is_admin')) {
            return redirect()->to('/admin/dashboard');
        }
        echo view('admin/login');
    }

    public function loginPost()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('username', $username)->first();
        if (!$admin || !password_verify($password, $admin['password'])) {
            return redirect()->to('/admin')->with('error', 'Username atau password salah.');
        }

        $this->session->set([
            'is_admin' => true,
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username']
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin');
    }

    public function dashboard()
    {
        $data['settings'] = $this->settingModel->getAll();
        $data['total_tokens'] = $this->tokenModel->countAllResults();
        $data['used_tokens'] = $this->tokenModel->where('used', 1)->countAllResults();
        $data['total_votes'] = $this->voteModel->countAllResults();
        echo view('admin/dashboard', $data);
    }

    public function settings()
    {
        $data['settings'] = $this->settingModel->getAll();
        echo view('admin/settings', $data);
    }

    public function saveSettings()
    {
        $post = $this->request->getPost();
        $this->settingModel->set('site_name', $post['site_name']);
        $this->settingModel->set('header_color', $post['header_color']);

        $imgFields = ['logo', 'banner', 'favicon'];
        $uploadPath = WRITEPATH . '../public/uploads/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        foreach ($imgFields as $f) {
            $file = $this->request->getFile($f);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $f . '_' . time() . '.' . $file->getClientExtension();
                $file->move($uploadPath, $newName);
                $this->settingModel->set($f, '/uploads/' . $newName);
            }
        }

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan disimpan.');
    }

    public function candidates()
    {
        $data['candidates'] = $this->candidateModel->findAll();
        echo view('admin/candidates_list', $data);
    }

    public function candidateForm($id = null)
    {
        $data = [];
        if ($id) {
            $data['candidate'] = $this->candidateModel->find($id);
        }
        echo view('admin/candidate_form', $data);
    }

    public function saveCandidate()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = WRITEPATH . '../public/uploads/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
            $newName = 'candidate_' . time() . '.' . $file->getClientExtension();
            $file->move($uploadPath, $newName);
            $data['photo'] = '/uploads/' . $newName;
        }

        if ($id) {
            $this->candidateModel->update($id, $data);
        } else {
            $this->candidateModel->insert($data);
        }

        return redirect()->to('/admin/candidates')->with('success', 'Data kandidat disimpan.');
    }

    public function deleteCandidate($id)
    {
        $this->candidateModel->delete($id);
        return redirect()->to('/admin/candidates')->with('success', 'Kandidat dihapus.');
    }

    public function results()
    {
        $candidates = $this->candidateModel->findAll();
        foreach ($candidates as & $c) {
            $c['votes'] = $this->voteModel->where('candidate_id', $c['id'])->countAllResults();
        }
        usort($candidates, function ($a, $b) {
            return $b['votes'] <=> $a['votes'];
        });

        $data['candidates'] = $candidates;
        $data['is_open'] = $this->settingModel->isOpen();
        echo view('admin/results', $data);
    }

    public function endElection()
    {
        $this->settingModel->set('is_open', 0);
        return redirect()->to('/admin/results')->with('success', 'Pemungutan suara dihentikan.');
    }
}
