let countryData = null;

document.getElementById("searchBtn").addEventListener("click", () => {
    const country = document.getElementById("country-input").value; 

    fetch(`fetch_country.php?country=${encodeURIComponent(country)}`)
        .then(res => res.json())
        .then(data => {
           if (data.error) { 
               document.getElementById("result").innerText = data.error;
               document.getElementById("saveBtn").style.display = "none";
           } else {
               countryData = data;
               document.getElementById("result").innerHTML = `
                   <p><strong>Country:</strong> ${data.name}</p>
                   <p><strong>Capital:</strong> ${data.capital}</p>
                   <p><strong>Region:</strong> ${data.region}</p>
                   <img src="${data.flags}" width="100">
               `;
               document.getElementById("saveBtn").style.display = "inline-block";
           }
        });
});

           document.getElementById("saveBtn").addEventListener("click", () => {
            fetch("save_country.php", {
                method: 'POST',
                headers: {
                    "Content-Type" : "application/json"
                },
                body: JSON.stringify(countryData)
            })
            .then(res => res.text())
            .then(msg => alert(msg));
});
         