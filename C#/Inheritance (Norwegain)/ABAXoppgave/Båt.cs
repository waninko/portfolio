using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABAXoppgave
{
    class Båt : Kjøretøy
    {
        public decimal Bruttotonnasje { get; }

        public Båt(string kjennetegn, decimal maksimalfart, decimal effekt, decimal bruttotonnasje)
            : base(kjennetegn, maksimalfart, effekt, null)
        {
            Bruttotonnasje = bruttotonnasje;
            Enheter.Add(nameof(Bruttotonnasje), "kg");
            Enheter[nameof(Fart)] = "knop";
        }

        public override void ToStringOptional(StringBuilder text)
        {
            Add(text, nameof(Bruttotonnasje), Bruttotonnasje);
        }
    }
}
