
import java.io.IOException;
import java.net.URISyntaxException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;
import java.util.stream.Collectors;


/**
 * 
 */
public class Day2
{
    public static void main(String args[]) throws URISyntaxException, IOException {
        var instance = new Day2();
        System.out.println("Answer 1: " + instance.task1());
        System.out.println("Answer 2: " + instance.task2());
    }
    
    private Integer task1() throws URISyntaxException, IOException {
        var lines = this.getInputLines();
        
        var hPos = 0;
        var depth = 0;
        
        for (int i = 0; i < lines.size(); i++) {
            int space = lines.get(i).indexOf(" ");
            int distance = Integer.parseInt(lines.get(i).substring(space+1));
            String direction = lines.get(i).substring(0, space);
            
            switch (direction) {
                case "forward":
                    hPos += distance;
                    break;
                case "down":
                    depth += distance;
                    break;
                case "up":
                    depth -= distance;
                    break;
            }
        }

        return hPos * depth;
    }
    
    private Integer task2() throws URISyntaxException, IOException {
        var lines = this.getInputLines();
        
        var hPos = 0;
        var depth = 0;
        var aim = 0;
        
        for (int i = 0; i < lines.size(); i++) {
            int space = lines.get(i).indexOf(" ");
            int distance = Integer.parseInt(lines.get(i).substring(space+1));
            String direction = lines.get(i).substring(0, space);
            
            switch (direction) {
                case "forward":
                    hPos += distance;
                    depth += (aim * distance);
                    break;
                case "down":
                    aim += distance;
                    break;
                case "up":
                    aim -= distance;
                    break;
            }
        }

        return hPos * depth;
    }
    
    private List<String> getInputLines() throws URISyntaxException, IOException {
        Path path = Paths.get(getClass()
                .getClassLoader()
                .getResource("day2_input.txt")
                .toURI());

        List<String> lines = Files.lines(path)
                .sequential()
                .collect(Collectors.toList());
        
        return lines;
    }
}
