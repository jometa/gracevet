<?

namespace App\Observers;
use App\RekamMedik;
use App\Pemilik;
use App\Pasien;
use DateTime;
use Log;

class RekamMedikObserver {
  public function created (RekamMedik $rekamMedik) {
    $pemilik = Pemilik::find($rekamMedik->pemilik->id);
    $pemilik->total_visit += 1;
    $pemilik->last_visit = $rekamMedik->tanggal;
    $pemilik->save();

    $pasien = Pasien::find($rekamMedik->pasien->id);
    $pasien->total_visit += 1;
    $pasien->last_visit = $rekamMedik->tanggal;
    $pasien->save();
  }

  public function deleted (RekamMedik $rekamMedik) {
    $pemilik = Pemilik::find($rekamMedik['pemilik']['id']);
    $pemilik->total_visit -= 1;
    $pemilik->last_visit = null;
    $pemilik->save();

    $pasien = Pasien::find($rekamMedik['pasien']['id']);
    $pasien->total_visit -= 1;
    $pasien->last_visit = null;
    $pasien->save();
  }
}