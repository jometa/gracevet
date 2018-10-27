<?

namespace App\Observers;
use App\RekamMedik;
use DateTime;
use Log;

class PenKhususRMObserver {
  public function created (RekamMedik $rm) {
    Log::channel('daily')->debug("I'm useless motherfucker!!! My dude even commenting my body!");
    // foreach ($rm->pen_khusus as $it) {
    //   Log::emergency('HIII');
    //   $pk = \App\TipePenKhusus::find($it->id);
    //   $pk->penggunaan += 1;
    //   $pk->save();
    // }
  }

  public function deleted (RekamMedik $rm) {
    // $rm->pen_khusus->each(function($it) {
    //   $pk = \App\TipePenKhusus::find($it->id);
    //   $pk->penggunaan -= 1;
    //   $pk->save();
    // });
    foreach ($rm->pen_khusus as $it) {
      Log::emergency('HIII');
      $pk = \App\TipePenKhusus::find($it->id);
      $pk->penggunaan -= 1;
      $pk->save();
    }
  }
}