using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.CodeAnalysis.CSharp.Syntax;
using Microsoft.EntityFrameworkCore;
using vaskeApp.Models;
using System.Configuration;

namespace vaskeApp.Controllers
{
    [Route("api/person")]
    [ApiController]
    public class PersonController : ControllerBase
    {
        private readonly PersonContext _context;

        public PersonController(PersonContext context)
        {
            _context = context;
        }


        // GET api/person
        [HttpGet]
        public ActionResult<IEnumerable<Person>> Get()
        {
            return _context.person.ToList();

        }

        //GET api/person/ id på person (leilighetsNR)
        [HttpGet("{id}")]
        public async Task<ActionResult<Person>> Get(string id)
        {
            //return "value";
            return await _context.person.FindAsync(id);


        }
    }
}
