<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Stream - SheShield</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }
        #videoElement {
            width: 100%;
            border-radius: 0.5rem;
        }
        .controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
            background: rgba(0, 0, 0, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
        }
        .control-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s;
        }
        .control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .recording {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen p-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-white mb-4 flex items-center">
                <span class="recording inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                Live Stream
            </h1>
            
            <div class="video-container mb-4">
                <video id="videoElement" autoplay playsinline></video>
                <div class="controls">
                    <button class="control-btn" id="micToggle" title="Toggle Microphone">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="control-btn" id="cameraToggle" title="Toggle Camera">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="control-btn" id="shareBtn" title="Share Stream">
                        <i class="fas fa-share"></i>
                    </button>
                    <button class="control-btn" id="endStream" title="End Stream">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                </div>
            </div>

            <div class="text-gray-400 text-sm">
                <p>Stream Status: <span id="streamStatus" class="font-semibold text-green-400">Active</span></p>
                <p class="mt-1">Connected to: Security Team</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script>
        let stream;
        const videoElement = document.getElementById('videoElement');
        const micToggle = document.getElementById('micToggle');
        const cameraToggle = document.getElementById('cameraToggle');
        const shareBtn = document.getElementById('shareBtn');
        const endStream = document.getElementById('endStream');

        async function startStream() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: true, 
                    audio: true 
                });
                videoElement.srcObject = stream;
            } catch (err) {
                console.error('Error accessing media devices:', err);
                alert('Unable to access camera and microphone. Please ensure you have granted the necessary permissions.');
            }
        }

        micToggle.addEventListener('click', () => {
            if (stream) {
                const audioTrack = stream.getAudioTracks()[0];
                audioTrack.enabled = !audioTrack.enabled;
                micToggle.innerHTML = audioTrack.enabled ? 
                    '<i class="fas fa-microphone"></i>' : 
                    '<i class="fas fa-microphone-slash"></i>';
            }
        });

        cameraToggle.addEventListener('click', () => {
            if (stream) {
                const videoTrack = stream.getVideoTracks()[0];
                videoTrack.enabled = !videoTrack.enabled;
                cameraToggle.innerHTML = videoTrack.enabled ? 
                    '<i class="fas fa-video"></i>' : 
                    '<i class="fas fa-video-slash"></i>';
            }
        });

        shareBtn.addEventListener('click', () => {
            const streamUrl = window.location.href;
            navigator.clipboard.writeText(streamUrl).then(() => {
                alert('Stream URL copied to clipboard!');
            });
        });

        endStream.addEventListener('click', () => {
            if (confirm('Are you sure you want to end the stream?')) {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                window.close();
            }
        });

        // Start stream when page loads
        startStream();

        // Handle page unload
        window.addEventListener('beforeunload', (e) => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>
