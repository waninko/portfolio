using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABAXoppgave
{
    class Fly : Kjøretøy
    {
        public decimal Vingespenn { get; }
        public decimal Lasteevne { get; }
        public decimal Egenvekt { get; }

        public Fly(string regNr, decimal effekt, decimal vingespenn, decimal lasteevne, decimal egenvekt, KjøretøyType type)
            : base(regNr, null, effekt, type)
        {
            Vingespenn = vingespenn;
            Lasteevne = lasteevne;
            Egenvekt = egenvekt;

            Enheter.Add(nameof(Vingespenn), "m");
            Enheter.Add(nameof(Lasteevne), "Tonn");
            Enheter.Add(nameof(Egenvekt), "Tonn");
        }

        public void KjørFly()
        {
            Console.WriteLine(nameof(Fly)+ " " + RegNr + " Starter opp, og flyr i en max hastighet på " + Fart);
            Console.WriteLine();
        }

        public override void ToStringOptional(StringBuilder text)
        {
            base.ToStringOptional(text);
            Add(text, nameof(Vingespenn), Vingespenn);
            Add(text, nameof(Lasteevne), Lasteevne);
            Add(text, nameof(Egenvekt), Egenvekt);
        }
    }
}
