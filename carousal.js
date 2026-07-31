//wait till it loads
document.addEventListener('DOMContentLoaded', function () {
    //get the elements from the dom
    const visuals = document.querySelectorAll('.product-visual');
    const previousButton = document.getElementById('previous-visual');
    const nextButton = document.getElementById('next-visual');

    //no visuals return
    if (visuals.length == 0) {
        return;
    }

    //carousal logic
    //current visual
    let mainIndex = 0;


    function showVisual(index) {
        //loop each visual and hide the ones that are not index
        visuals.forEach(function (visual, visualIndex) {
            
            //hide if not the visual to show
            if (visualIndex === index) {
                visual.hidden = false;
            } else {
                visual.hidden = true;
            }

            //pause the video if hiding a video
            if (visualIndex !== index) {
                //get the video
                const video = visual.querySelector('video');
                if (video) {    
                    video.pause();
                }
            }
        });
    }
    //event listener for previous button
    previousButton.addEventListener('click', function () {
        //wrap around if 0
        mainIndex--;
        if (mainIndex < 0) {
            mainIndex = visuals.length - 1;
        }
        //show the visual
        showVisual(mainIndex);
    });

    //event listener for next button
    nextButton.addEventListener('click', function () {
        //wrap around if last
        mainIndex++;
        if (mainIndex >= visuals.length) {
            mainIndex = 0;
        }
        //show the visual
        showVisual(mainIndex);
    });
});