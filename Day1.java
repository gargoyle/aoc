
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
public class Day1
{
    public static void main(String args[]) throws URISyntaxException, IOException {
        var instance = new Day1();
        System.out.println("Answer 1: " + instance.task1());
        System.out.println("Answer 2: " + instance.task2());
    }
    
    private Integer task1() throws URISyntaxException, IOException {
        var lines = this.getInputLines();
        var numIncreases = 0;
        
        for (int i = 1; i < lines.size(); i++) {
            numIncreases += (lines.get(i) > lines.get(i - 1)) ? 1 : 0;
        }

        return numIncreases;
    }
    
    private Integer task2() throws URISyntaxException, IOException {
        var lines = this.getInputLines();
        
        var previousSum = 0;
        var numWindowIncreases = 0;
        
        for (int i = 2; i < lines.size(); i++) {
            var sum = lines.get(i - 2) + lines.get(i - 1) + lines.get(i);
            if ((sum > previousSum) && (previousSum != 0)) {
                numWindowIncreases++;
            }
            previousSum = sum;
        }
        
        return numWindowIncreases;
    }
    
    private List<Integer> getInputLines() throws URISyntaxException, IOException {
        Path path = Paths.get(getClass()
                .getClassLoader()
                .getResource("day1_input.txt")
                .toURI());

        List<Integer> lines = Files.lines(path)
                .map(Integer::valueOf)
                .sequential()
                .collect(Collectors.toList());
        
        return lines;
    }
}
