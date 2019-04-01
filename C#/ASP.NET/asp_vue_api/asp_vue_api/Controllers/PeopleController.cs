using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using asp_vue_api.Model;
using Microsoft.AspNetCore.Mvc;

namespace asp_vue_api.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class PeopleController : ControllerBase
    {
        // GET api/values
        [HttpGet]
        public ActionResult<IEnumerable<Person>> Get()
        {
            return new Person[]
            {
                new Person{ Id=1, Name= "Name1", Age = 11},
                new Person{ Id=2, Name= "Name2", Age = 21},
                new Person{ Id=3, Name= "Name3", Age = 31},
            };
        }

        
    }
}
