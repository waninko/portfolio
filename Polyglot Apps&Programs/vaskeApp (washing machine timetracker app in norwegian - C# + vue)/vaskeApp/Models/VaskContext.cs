
using Microsoft.EntityFrameworkCore;


namespace vaskeApp.Models
{
    public class VaskContext : DbContext
    {
        public VaskContext(DbContextOptions<VaskContext> options) : base(options)
        {

        }

        protected override void OnModelCreating(ModelBuilder builder)
        {
            base.OnModelCreating(builder);
            //builder.Entity<vaskOversikt>().ToTable("vaskOversikt");
        }

        //public DbSet<Vask> vaskOversikt{ get; set; }
        public DbSet<Vask> vaskeTabell { get; set; }
    }
}
