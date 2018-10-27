<?

namespace App\Observers;
use App\RekamMedik;
use App\JenisHewan;
use App\JHRas;
use DateTime;

class JenisHewanRMObserver {
  public function created(RekamMedik $rm) {
    $tanggal = $rm->tanggal;
    $jhRas_id = $rm->pasien['jh_ras_id'];

    $jhRas = JHRas::with('jenis_hewan')->find($jhRas_id);

    $jh = JenisHewan::find($jhRas->jenis_hewan->id);

    $jh->total_visit += 1;
    $jh->last_visit = $tanggal;
    $jhRas->total_visit += 1;
    $jhRas->last_visit = $tanggal;
    $jh->save();
    $jhRas->save();

  }

  public function deleted(RekamMedik $rm) {
    $jhRas_id = $rm->pasien['jh_ras_id'];
    
    $jhRas = JHRas::with('jenis_hewan')->find($jhRas_id);

    $jh = JenisHewan::find($jhRas->jenis_hewan->id);

    $jh->total_visit -= 1;
    $jh->last_visit = null;
    $jhRas->total_visit -= 1;
    $jhRas->last_visit = null;
    $jh->save();
    $jhRas->save();
  }
}