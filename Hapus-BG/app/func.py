from flask import Flask, request, jsonify, send_file
from rembg import remove
from PIL import Image, ImageColor
from flask_cors import CORS
import io
import logging

app = Flask(__name__)
CORS(app)

ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'webp'}
3
def allowed_file(filename):
    return '.' in filename and \
           filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route('/process-image', methods=['POST'])
def process_image():
    if 'input_image' not in request.files:
        return jsonify({"error": "No input_image provided"}), 400
    
    input_file = request.files['input_image']
    
    if input_file.filename == '':
        return jsonify({"error": "No selected file"}), 400
        
    if not allowed_file(input_file.filename):
        return jsonify({"error": "Invalid file type. Allowed: PNG, JPG, JPEG, WEBP"}), 400
    
    try:
        input_image = Image.open(input_file.stream).convert("RGBA")
        
        params = {
            'position_x': int(request.form.get('position_x', 0)),
            'position_y': int(request.form.get('position_y', 0)),
            'bg_color': request.form.get('bg_color', '')
        }
        
        # Remove background
        output_image = remove(input_image)
        
        # Apply background color if specified
        if params['bg_color']:
            try:
                rgb_color = ImageColor.getcolor(f"#{params['bg_color']}", "RGB")
                rgba_color = rgb_color + (255,)
                background = Image.new("RGBA", output_image.size, rgba_color)
                output_image = Image.alpha_composite(background, output_image)
            except ValueError:
                pass  # Keep transparent if invalid color
        
        # Prepare PNG output
        output_buffer = io.BytesIO()
        output_image.save(output_buffer, format='PNG', optimize=True)
        output_buffer.seek(0)
        
        return send_file(output_buffer, mimetype='image/png')

    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({'status': 'healthy'}), 200

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)