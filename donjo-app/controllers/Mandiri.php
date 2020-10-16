<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  File ini:
 *
 * Controller untuk modul Layanan Mandiri
 *
 * donjo-app/controllers/Mandiri.php
 *
 */
/*
 *  File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package	OpenSID
 * @author	Tim Pengembang OpenDesa
 * @copyright	Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright	Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license	http://www.gnu.org/licenses/gpl.html	GPL V3
 * @link 	https://github.com/OpenSID/OpenSID
 */

class Mandiri extends Admin_Controller {

	private $_set_page;
	private $_list_session;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mandiri_model');

		$this->modul_ini = 14;
		$this->sub_modul_ini = 56;
		$this->_set_page = ['10', '2', '3'];
		$this->_list_session = ['cari', 'order_by'];
		//$this->_set_page = ['50', '100', '200'];
	}

	public function clear()
	{
		$this->session->unset_userdata(['cari']);
		$this->session->per_page = $this->_set_page[0];
		$this->session->order_by = 6;
		redirect('mandiri');
	}

	public function index($p = 1)
	{
		foreach ($this->_list_session as $list)
		{
				$data[$list] = $this->session->$list ?: '';
		}

		$per_page = $this->input->post('per_page');
		if (isset($per_page))
			$this->session->per_page = $per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->_set_page;
		$data['paging'] = $this->mandiri_model->paging($p);
		$data['main'] = $this->mandiri_model->list_data($data['order_by'], $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->mandiri_model->autocomplete();

		$this->render('mandiri/mandiri', $data);
	}

	public function filter($filter = '', $order_by = '')
	{
		$value = $order_by ?: $this->input->post($filter);
		if ($value != '')
			$this->session->$filter = $value;
		else $this->session->unset_userdata($filter);
		redirect('mandiri');
	}

	public function ajax_pin($id_pend = '')
	{
		$data['penduduk'] = $this->mandiri_model->list_penduduk();
		if ($id_pend)
		{
			$data['id_pend'] = $id_pend;
			$data['form_action'] = site_url("mandiri/update/$id_pend");
		}
		else
		{
			$data['id_pend'] = NULL;
			$data['form_action'] = site_url("mandiri/insert");
		}
		$this->load->view('mandiri/ajax_pin', $data);
	}

	public function insert()
	{
		$this->mandiri_model->insert();
		redirect('mandiri');
	}

	public function update($id_pend)
	{
		$this->mandiri_model->update($id_pend);
		redirect('mandiri');
	}

	public function delete($id = '')
	{
		$this->redirect_hak_akses('h');
		$this->mandiri_model->delete($id);
		redirect('mandiri');
	}

	public function kirim($id_pend = '')
	{
		$data = $this->mandiri_model->get_mandiri($id_pend);
		$desa = $this->header['desa'];

		if (cek_koneksi_internet() && $data['telepon'])
		{
			$no_tujuan = "+62" . substr($data['telepon'], 1);

			$pesan = "Selamat Datang di Layanan Mandiri Desa " . $desa[nama_desa] . " %0A%0AUntuk Menggunakan Layanan Mandiri, silahkan kunjungi " . site_url('mandiri_web') . "%0AAkses Layanan Mandiri : %0A- NIK : " . sensor_nik_kk($data[nik]) . " %0A- PIN : " . $data['vpin'] . "%0A%0AHarap merahasiakan NIK dan PIN untuk keamanan data anda.%0A%0AHormat kami %0AKepala Desa " . $desa[nama_desa] . "%0A%0A%0A" . $desa[nama_kepala_desa];

			// Update vpin = NULL jika vpin sudah dikirim
			$this->mandiri_model->vpin($id_pend);

			redirect("https://api.whatsapp.com/send?phone=$no_tujuan&text=$pesan");
		}

		redirect('mandiri');
	}

}
