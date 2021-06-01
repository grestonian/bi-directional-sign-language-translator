import cv2
from PIL import Image
from flask import Flask, render_template
from flask.wrappers import Response

from sign2text.app import Sign2Text

app = Flask(__name__)
s2t = Sign2Text()

@app.route("/", methods=['GET'])
def index():
    return render_template('index.html')

@app.route('/current_symbol')
def current_symbol():
    return s2t.current_symbol

@app.route('/video_feed')
def video_feed():
    return Response(generate_frame(), mimetype='multipart/x-mixed-replace; boundary=frame')

def generate_frame():
    camera = cv2.VideoCapture(0)
    while True:
        success, frame = camera.read()
        
        if not success:
            break
        else:
            image = s2t.process(frame)

            ret, buffer = cv2.imencode('.jpg', image)
            frame_final = buffer.tobytes()
            
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame_final + b'\r\n')  # concat frame one by one and show result

if __name__ == '__main__':
    port = 8001 #the custom port you want
    app.run(host='127.0.0.1', port=port) # don't set debug=True