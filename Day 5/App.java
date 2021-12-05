
import java.awt.Point;
import java.io.IOException;
import java.net.URISyntaxException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;


/**
 * 
 */
public class App
{
    public static void main(String args[]) throws URISyntaxException, IOException {
        var start = System.nanoTime();
        var app = new App();
        app.run();
        var duration = System.nanoTime() - start;
        NumberFormat formatter = new DecimalFormat("#0.00000");
        System.out.print("Execution time is " + formatter.format(duration / 1000000000d) + " seconds");
    }
    
    private void run() throws URISyntaxException, IOException {
        var lines = this.getInputLines();
        Map<Point, Integer> intersects = new HashMap<>();
        List<Point> dangerPoints = new ArrayList<>();
        
        lines.forEach(l -> {
            Line.fromVentData(l).points().forEach(p -> {
                if (intersects.containsKey(p)) {
                    var count = intersects.get(p);
                    intersects.replace(p, ++count);
                    if (!dangerPoints.contains(p)) {
                        dangerPoints.add(p);
                    }
                } else {
                    intersects.put(p, 1);
                }
            });
        });
        System.out.println("Danger points: " + dangerPoints.size());
    }
    
    private List<String> getInputLines() throws URISyntaxException, IOException {
        Path path = Paths.get(getClass()
                .getClassLoader()
                .getResource("input.txt")
                .toURI());

        List<String> lines = Files.lines(path)
                .sequential()
                .collect(Collectors.toList());
        
        return lines;
    }
}
