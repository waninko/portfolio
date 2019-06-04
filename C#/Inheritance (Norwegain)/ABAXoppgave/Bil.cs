using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABAXoppgave
{
    class Bil : Kjøretøy
    {
        public string Farge { get; }

        public Bil(string regNr, decimal fart, decimal effekt, KjøretøyType type, string farge)
            : base(regNr, fart, effekt, type)

        {
            Farge = farge;
        }


        public void KjørBil()
        {
            Console.WriteLine(nameof(Bil)+" "+ RegNr + " starter opp, og har en max fart på " + Fart);

        }

        public override void ToStringOptional(StringBuilder text)
        {
            base.ToStringOptional(text);
            Add(text, nameof(Farge), Farge);
        }


    }
}
