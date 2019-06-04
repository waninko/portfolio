using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABAXoppgave
{
    class Program
    {
        static void Main(string[] args)
        {   //regNr, fart, effekt, type, farge//
            var bil1 = new Bil("NF123456", 200, 147, KjøretøyType.LettKjøretøy, "grønn");
            bil1.Vis();
            var bil2 = new Bil("NF654321", 195, 150, KjøretøyType.LettKjøretøy, "blå");
            bil2.Vis();
            //sammenligne biler
            bil1.Sammenligne(bil2, "Bil-1  & Bil-2 ");

            var fly1 = new Fly("LN1234", 1000, 30, 2, 10, KjøretøyType.Jetfly);
            fly1.Vis();
            fly1.KjørFly();

            var båt = new Båt("ABC123", 30, 100, 500);
            båt.Vis();

        }
    }
}
