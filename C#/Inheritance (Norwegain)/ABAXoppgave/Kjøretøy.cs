using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ABAXoppgave
{
    class Kjøretøy
    {
        public string RegNr { get; }
        public decimal? Fart { get; } // ? betyr at den kan ha verdien NULL
        public decimal Effekt { get; }
        public KjøretøyType? Type{ get; }


        //sette opp string som index, "henge på" en string
        protected Dictionary<string, string> Enheter = new Dictionary<string, string>
        {
            {nameof(Fart), "km/t"},
            {nameof(Effekt), "kw"}
        };



        public Kjøretøy(string regNr, decimal? fart, decimal effekt, KjøretøyType? type)
        {
            RegNr = regNr;
            Fart = fart;
            Effekt = effekt;
            Type = type;

        }

        public override string ToString()  //ovverider den innebygde ToString til å heller printe ut en txt som et object
        {
            var text = new StringBuilder();
            text.AppendLine(GetType().Name);
            Add(text, nameof(RegNr), RegNr); //(inniHerErLabelen), HerErVariablenDenFårVerdiAv
            Add(text, nameof(Fart), Fart);
            Add(text, nameof(Effekt), Effekt);
            ToStringOptional(text);
            return text.ToString();
        }

        protected void Add(StringBuilder text, string name, object value)
        {
            if (value == null) return;
            text.Append(" ");
            text.Append(name);
            text.Append("=");
            text.Append(value);  //object value -> alt kan være objecter, og gjøres om til det som spørres etter der den brukes

            if (Enheter.ContainsKey(name)) text.Append(Enheter[name]);
            text.AppendLine();
        }

        public virtual void ToStringOptional(StringBuilder text)
        {
            Add(text, nameof(KjøretøyType), Type);
        }

        public override bool Equals(object obj)
        {
            return Equals(obj as Kjøretøy);
        }

        private bool Equals(Kjøretøy kjøretøy)
        {
            return kjøretøy != null && GetType() == kjøretøy.GetType() && RegNr == kjøretøy.RegNr;
        }

        public void Vis()
        {
            Console.WriteLine(ToString());
        }

        public void Sammenligne(Kjøretøy kjøretøy2, string prefix)
        {
            var erLike = Equals(kjøretøy2);
            var erLikeTekst = erLike ? string.Empty : "ikke  ";
            Console.WriteLine(prefix);
            Console.WriteLine("er {0}samme kjøretøy!", erLikeTekst);
            Console.WriteLine();
        }
    }
}
