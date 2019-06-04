using System.ComponentModel.DataAnnotations;


namespace vaskeApp.Models
{
    public class Person
    {
        [Key]
        public string LeilighetsNR { get; set; }
        public string Navn { get; set; }
    }
}
