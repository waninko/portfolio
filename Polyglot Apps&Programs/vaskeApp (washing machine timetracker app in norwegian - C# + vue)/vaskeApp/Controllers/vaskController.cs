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
    [Route("api/vask")]
    [ApiController]
    public class VaskController : ControllerBase
    {
        private readonly VaskContext _context;

        public VaskController(VaskContext context)
        {
            _context = context;
        }


        // GET api/values
        [HttpGet]
        public ActionResult<IEnumerable<Vask>> GetVask()
        {
        
            return _context.vaskeTabell.ToList();

        }
        //public async Task<ActionResult<Vask>> Get()
        //{
        //    return await _context.vaskOversikt.ToListAsync();
        //}

        // GET api/vask/spesifik vaskID
        [HttpGet("{id}")]
        public async Task<ActionResult<Vask>> GetVask(int id)
        {
            //return "value";
            return await _context.vaskeTabell.FindAsync(id);
            
        }

        // POST api/vask  
        [HttpPost]
        public async Task<ActionResult<Vask>>PostVask(Vask vask)
        {
            _context.vaskeTabell.Add(vask);
            await _context.SaveChangesAsync();

            return vask;
            //return CreatedAtAction(nameof(GetVask), new { id = vask.vaskID }, vask);

        }

        // PUT api/vask/ id på vask du vil endre
        [HttpPut("{id}")]
        public async Task<ActionResult<Vask>>UpdateVask(int id, [FromBody] Vask vask)
         {
             var exists = await _context.vaskeTabell.AnyAsync(v => v.vaskID == id);
             if (!exists)
             {
                 Console.Beep();
                  return NotFound();
                }

            _context.vaskeTabell.Update(vask);

            await _context.SaveChangesAsync();

            return Ok();

         }

        // DELETE api/vask/ id på vask som skal slettes
        [HttpDelete("{id}")]
        public async Task<ActionResult> Delete(int id)
        {
            var valgtVask = await _context.vaskeTabell.FindAsync(id);

            _context.vaskeTabell.Remove(valgtVask);

            await _context.SaveChangesAsync();

            return Ok();
        }
    }
}
