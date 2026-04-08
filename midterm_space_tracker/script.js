document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.fetch-data-btn');
    const display = document.getElementById('telemetry-display');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const apiId = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            
            display.innerHTML = `<p class="text-warning"><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Establishing uplink...</p>`;

            // Route through our PHP proxy
            fetch(`api_proxy.php?type=${type}&id=${apiId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) throw new Error(data.error);

                    if (type === 'station') {
                        // N2YO Station Formatting
                        if(!data.passes || data.passes.length === 0) {
                            display.innerHTML = `<h5 class="text-danger">No local passes detected.</h5><p class="text-faint-custom">Target out of range for the next 48 hours.</p>`;
                        } else {
                            const passTime = new Date(data.passes[0].startUTC * 1000).toLocaleString();
                            display.innerHTML = `
                                <h4 class="fw-bold text-success">Target Acquired</h4>
                                <p class="fs-5 mb-1"><strong>Next Flyover:</strong> ${passTime}</p>
                                <p class="text-muted-custom mb-0"><strong>Trajectory:</strong> ${data.passes[0].startCompass} to ${data.passes[0].endCompass}</p>
                                <p class="text-muted-custom"><strong>Duration:</strong> ${data.passes[0].duration} seconds</p>
                            `;
                        }
                    } else if (type === 'planet') {
                        // Solar System API Planet Formatting
                        display.innerHTML = `
                            <h4 class="fw-bold text-info">Planetary Scan Complete</h4>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <p class="text-muted-custom mb-0">Gravity</p>
                                    <p class="fs-5">${data.gravity} m/s²</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted-custom mb-0">Mean Radius</p>
                                    <p class="fs-5">${data.meanRadius} km</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted-custom mb-0">Escape Velocity</p>
                                    <p class="fs-5">${data.escape / 1000} km/s</p>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    display.innerHTML = `<p class="text-danger">Uplink Failed: ${error.message}</p>`;
                });
        });
    });
});