
import java.awt.Point;
import java.util.ArrayList;
import java.util.List;
import java.util.stream.IntStream;


/**
 * 
 */
public class Line
{
    private int startX;
    private int startY;
    private int endX;
    private int endY;

    public Line(int startX, int startY, int endX, int endY) {
        this.startX = startX;
        this.startY = startY;
        this.endX = endX;
        this.endY = endY;
    }
    
    public List<Point> points() {
        var points = new ArrayList<Point>();
        
        if (startX == endX) {
            IntStream.range(startY, endY+1).forEachOrdered(y -> {
                points.add(new Point(startX, y));
            });
        } else {
            var slope = (endY - startY)/(endX - startX);
            var icept = startY - (slope * startX);
            IntStream.range(startX, endX+1).forEachOrdered(x -> {
                var y = (slope*x) + icept;
                points.add(new Point(x, y));
            });
        }
        
        return points;
    }
    
    public static Line fromVentData(String raw) {
        String[] startEnd = raw.split(" -> ");
        String[] start = startEnd[0].split(",");
        String[] end = startEnd[1].split(",");
        
        return new Line(
                Integer.parseInt(start[0]), 
                Integer.parseInt(start[1]), 
                Integer.parseInt(end[0]), 
                Integer.parseInt(end[1]));
    }
}
