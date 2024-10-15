const width = 800;
const height = 500;

const svg = d3.select('body')
  .append('svg')
  .attr('width', width)
  .attr('height', height);

const projection = d3.geoOrthographic()
  .translate([width / 2, height / 2])
  .scale(width / 2 - 20)
  .clipAngle(90)
  .precision(0.6);

const path = d3.geoPath().projection(projection);

svg.call(d3.zoom()
  .scaleExtent([1, 8])
  .on('zoom', zoomed));

function zoomed(event) {
  const { transform } = event;
  projection.translate([transform.x, transform.y]);
  projection.scale(transform.k * (width / 2 - 20));
  svg.selectAll('path').attr('d', path);
}

d3.json('https://unpkg.com/world-atlas@1/world/110m.json')
  .then(data => {
    svg.selectAll('path')
      .data(topojson.feature(data, data.objects.countries).features)
      .enter()
      .append('path')
      .attr('d', path)
      .on('click', clicked);
  });

function clicked(event, d) {
  const countryName = d.properties.name;
  alert(countryName);
}
