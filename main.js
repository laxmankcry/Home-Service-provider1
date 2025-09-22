const services = [
  {id:1,name:'Electrician',desc:'Home electrical repair and installations',price:300},
  {id:2,name:'Plumber',desc:'Pipes, leaks, and sanitary fittings',price:250},
  {id:3,name:'Mobile Repair',desc:'Phone screen, battery, and hardware repair',price:500}
];
const grid = document.getElementById('servicesGrid');
document.getElementById('year').textContent = new Date().getFullYear();

function renderCards(list){
  grid.innerHTML='';
  list.forEach(s=>{
    const card=document.createElement('div');
    card.className='card';
    card.innerHTML=`<h3>${s.name}</h3><p>${s.desc}</p><div class="price">₹${s.price}</div>`;
    grid.appendChild(card);
  });
}
renderCards(services);
<script>
  document.getElementById('year').textContent = new Date().getFullYear();
</script>

